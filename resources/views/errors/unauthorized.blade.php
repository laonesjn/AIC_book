<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Unauthorized - Token Missing</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background: #ffffff;
        width: 380px;
        padding: 30px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .icon {
        font-size: 60px;
        color: #ff4d4d;
        margin-bottom: 15px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.08); }
        100% { transform: scale(1); }
    }

    h2 {
        margin: 0 0 10px;
        color: #333;
    }

    p {
        color:red;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 8px;
        background-color: #4b6cb7;
        color: white;
        border: none;
        outline: none;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: 0.2s;
    }

    .btn:hover {
        background-color: #3651a2;
    }

    a {
        color: #4b6cb7;
        text-decoration: none;
        font-weight: 600;
    }
</style>

</head>
<body>

<div class="card">
    <div class="icon">⚠️</div>
    <h2>Unauthorized Access</h2>
    <p>{{ $errorMessage ?? 'Unauthorized access.' }}<br>Please log in to continue.</p>
   <button class="btn" onclick="window.location.href='{{ route('admin.login.view') }}'">Go to Login</button>


</div>

</body>
</html>
