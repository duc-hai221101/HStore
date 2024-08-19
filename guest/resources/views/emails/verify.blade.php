<!-- resources/views/emails/verify.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận địa chỉ email</title>
</head>
<body>
    <h1>Chào, {{ $user->name }}</h1>
    <p>Cảm ơn bạn đã đăng ký tài khoản! Vui lòng nhấp vào liên kết bên dưới để xác nhận địa chỉ email của bạn:</p>
    <a href="{{ route('verify-email', ['email' => $user->email]) }}">Xác nhận email</a>
</body>
</html>
