<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Sent Successfully</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .success-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.8s ease-out;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: bounce 1s ease-in-out;
        }
        
        .success-icon::before {
            content: "";
            position: absolute;
            width: 30px;
            height: 60px;
            border-right: 5px solid white;
            border-bottom: 5px solid white;
            transform: rotate(45deg) translate(5px, -10px);
        }
        
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2.2rem;
            font-weight: 700;
        }
        
        p {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .highlight {
            color: #4CAF50;
            font-weight: 600;
        }
        
        .back-button {
            display: inline-block;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 14px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        
        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }
        
        .back-button:active {
            transform: translateY(1px);
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            border-radius: 50%;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        
        @media (max-width: 576px) {
            .success-container {
                padding: 40px 25px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon"></div>
        <h1>Request Sent Successfully!</h1>
        <p>Thank you for contacting us. Your request has been received and our admin team will contact you <span class="highlight">very soon</span>.</p>
        <a href="{{ route('client.publications') }}" class="back-button">Go Back</a>
    </div>

    <script>
        // Simple confetti effect
        function createConfetti() {
            const colors = ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0'];
            const container = document.body;
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = '-10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = confetti.style.width;
                
                container.appendChild(confetti);
                
                // Animation
                const animation = confetti.animate([
                    { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
                    { transform: `translateY(${window.innerHeight}px) rotate(${Math.random() * 360}deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 3000 + 2000,
                    easing: 'cubic-bezier(0.1, 0.8, 0.3, 1)'
                });
                
                animation.onfinish = () => confetti.remove();
            }
        }
        
        // Trigger confetti when page loads
        window.onload = function() {
            createConfetti();
        };
    </script>
</body>
</html>