<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAddRequest;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Traits\deleteTrait;
use App\Traits\StorageImageTraits;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\Storage;

use App\Components\MenuRecusive;
use App\Components\Recusive;

class AdProductController extends Controller
{
    use StorageImageTraits,deleteTrait;
    private $category;
    private $product;
    private $productImage;
    private $productTag;
    private $tag;

    public function __construct(Category $category, Product $product, ProductImage $productImage, ProductTag $productTag, Tag $tag)
    {
        $this->category = $category;
        $this->product = $product;
        $this->productImage = $productImage;
        $this->productTag = $productTag;
        $this->tag = $tag;
    }

    public function getCategory($parent_id)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->dequy($parent_id);
        return $htmlOption;
    }
    public function search(Request  $request){
        $query = $request->input('query');
        $products= Product::all();
        if (!empty($query)) {
            $products->where('name', 'like', '%' . $query . '%');
        }
        $categoryId = $request->input('category_id'); 
        $sortBy = $request->input('sort_by'); 
    
        $query = $this->product->latest();
        if ($categoryId) {
            $categoryIds = $this->getCategoryIdsWithChildren($categoryId);
            $query->whereIn('category_id', $categoryIds);
        }
    
        $products = Product::paginate(10); 
        $categories = $this->category->all();
    return view('admin.product.index', compact('products', 'categories'));

    }

    public function index(Request $request)
{
    $searchQuery = $request->input('query'); // Từ khóa tìm kiếm
    $categoryId = $request->input('category_id'); // ID danh mục để lọc
    $sortBy = $request->input('sort_by'); // Cách sắp xếp

    // Khởi tạo truy vấn sản phẩm
    $query = $this->product->latest();

    $query->when($searchQuery, function ($queryBuilder, $searchQuery) {
        return $queryBuilder->where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('content', 'like', "%{$searchQuery}%")
                  ->orWhereHas('category', function ($query) use ($searchQuery) {
                      $query->where('name', 'like', "%{$searchQuery}%");
                  });
        });
    });

    if ($categoryId) {
        $categoryIds = $this->getCategoryIdsWithChildren($categoryId);
        $query->whereIn('category_id', $categoryIds);
    }

    $query->when($sortBy, function ($queryBuilder, $sortBy) {
        switch ($sortBy) {
            case 'views_asc':
                return $queryBuilder->orderBy('views_count', 'asc');
            case 'views_desc':
                return $queryBuilder->orderBy('views_count', 'desc');
            case 'price_asc':
                return $queryBuilder->orderBy('price', 'asc');
            case 'price_desc':
                return $queryBuilder->orderBy('price', 'desc');
            default:
                return $queryBuilder->orderBy('views_count', 'desc'); // Sắp xếp mặc định
        }
    });

    $products = $query->paginate(5);
    $categories = $this->category->all();
    return view('admin.product.index', compact('products', 'categories'));
}
    protected function getCategoryIdsWithChildren($parentId)
{
    $categoryIds = $this->category->where('parent_id', $parentId)->pluck('id')->toArray();
    $categoryIds[] = $parentId; 

    $childCategoryIds = $this->category->whereIn('parent_id', $categoryIds)->pluck('id')->toArray();
    $categoryIds = array_merge($categoryIds, $childCategoryIds);

    return $categoryIds;
}

    public function create()
    {
        $htmlOption = $this->getCategory($parentid = "");
        return view('admin.product.add', compact('htmlOption'));
    }

    public function store(ProductAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];

            $dataUp = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUp)) {
                $dataProductCreate['feature_image_name'] = $dataUp['file_name'];
                $dataProductCreate['feature_image_path'] = $dataUp['file_path'];
            }

            $product = $this->product->create($dataProductCreate);

            // Insert product images
            if ($request->hasFile('image_path')) {
                foreach ($request->file('image_path') as $fileItem) {
                    $dataUploadDetail = $this->storageTraitUploadMutiple($fileItem, 'product');
                    $product->images()->create([
                        'product_id' => $product->id,
                        'image_path' => $dataUploadDetail['file_path'],
                        'image_name' => $dataUploadDetail['file_name'],
                    ]);
                }
            }

            // Insert tags
            if (!empty($request->tags)) {
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                    $tagIds[] = $tagInstance->id;
                }
                $product->totags()->attach($tagIds);
            }

            DB::commit();
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line :' . $exception->getLine());
            // Handle exception here (e.g., show error message to user)
        }
    }

    public function edit($id)
    {
        $product = $this->product->findOrFail($id);
        $htmlOption = $this->getCategory($product->category_id);
        return view('admin.product.edit', compact('product', 'htmlOption'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->findOrFail($id);
    
            $dataProductUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'category_id' => $request->category_id,
            ];
    
            if ($request->hasFile('feature_image_path')) {
                $dataUp = $this->storageTraitUpload($request, 'feature_image_path', 'product', $product->feature_image_path);
                if (!empty($dataUp)) {
                    $dataProductUpdate['feature_image_name'] = $dataUp['file_name'];
                    $dataProductUpdate['feature_image_path'] = $dataUp['file_path'];
                }
            }
    
            if ($request->hasFile('image_path')) {
                $product->images()->delete(); // Delete existing images
                foreach ($request->file('image_path') as $fileItem) {
                    $dataUploadDetail = $this->storageTraitUploadMutiple($fileItem, 'product');
                    $product->images()->create([
                        'product_id' => $product->id,
                        'image_path' => $dataUploadDetail['file_path'],
                        'image_name' => $dataUploadDetail['file_name'],
                    ]);
                }
            }
    
            if (!empty($request->tags)) {
                $tagIds = [];
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                    $tagIds[] = $tagInstance->id;
                    
                }
                $product->totags()->sync($tagIds);

            } else {
                $product->totags()->detach(); // Remove all tags if none selected
            }
    
            $product->update($dataProductUpdate);
            DB::commit();
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line :' . $exception->getLine());
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }
    
    public function delete($id)
{
    return $this->deleteModel($id,$this->product);

}

}
