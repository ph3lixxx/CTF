<?php
// admin-login.php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $raw_password = $_POST['password'] ?? '';
    
    // Bersihkan input untuk display saja
    $clean_username = htmlspecialchars($username);
    $clean_password = htmlspecialchars($raw_password);
    
    // Vulnerable SQL query
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$raw_password'";
    
    // Validasi payload
    if (strpos($raw_password, "YWRtaW4nIG9yIDE9MS0tCg==") !== false && $username === 'admin') {
        echo "<div class='access-granted'>DAH BISA HEK NASA BANK<br>FLAG: CYC{priadingjntimdakpernahmenyesal}</div>";
        exit;
    }
    
    echo "<div class='sql-query'>Generated query: " . htmlspecialchars($sql) . "</div>";
    echo "<div class='access-denied'>TES YANG LAIN BANK</div>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CYSCOM PNC CTF</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');
        
        :root {
            --matrix-green: #0f0;
            --dark-bg: #000;
            --glow: 0 0 10px var(--matrix-green);
            --red-glow: 0 0 10px #f00;
        }
        
        body {
            background-color: var(--dark-bg);
            color: var(--matrix-green);
            font-family: 'Share Tech Mono', monospace;
            margin: 0;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }
        
        #matrix {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            border: 1px solid var(--matrix-green);
            padding: 30px;
            box-shadow: var(--glow);
            position: relative;
            overflow: hidden;
            animation: border-flicker 2s infinite alternate;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            text-shadow: var(--glow);
            animation: flicker 3s infinite alternate;
        }
        
        .terminal-line {
            margin-bottom: 15px;
            opacity: 0;
            animation: typeIn 0.5s forwards;
        }
        
        .terminal-line:nth-child(1) { animation-delay: 0.5s; }
        .terminal-line:nth-child(2) { animation-delay: 1s; }
        .terminal-line:nth-child(3) { animation-delay: 1.5s; }
        .terminal-line:nth-child(4) { animation-delay: 2s; }
        
        input {
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--matrix-green);
            color: var(--matrix-green);
            width: 100%;
            padding: 10px 5px;
            margin-bottom: 20px;
            font-family: 'Share Tech Mono', monospace;
            box-shadow: var(--glow);
            outline: none;
        }
        
        input::placeholder {
            color: #0f04;
        }
        
        button {
            background: transparent;
            color: var(--matrix-green);
            border: 1px solid var(--matrix-green);
            padding: 10px 20px;
            cursor: pointer;
            font-family: 'Share Tech Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--glow);
            transition: all 0.3s;
        }
        
        button:hover {
            background: var(--matrix-green);
            color: var(--dark-bg);
            text-shadow: none;
        }
        
        .cursor {
            display: inline-block;
            width: 10px;
            height: 20px;
            background: var(--matrix-green);
            margin-left: 5px;
            animation: blink 1s infinite;
            vertical-align: middle;
        }
        
        .access-denied {
            color: #f00;
            text-shadow: var(--red-glow);
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #f00;
            display: none;
        }
        
        .access-granted {
            color: var(--matrix-green);
            text-shadow: var(--glow);
            margin-top: 20px;
            padding: 20px;
            border: 1px solid var(--matrix-green);
            text-align: center;
            font-size: 1.5em;
            line-height: 1.5;
        }
        
        .sql-query {
            color: #ff0;
            margin: 15px 0;
            padding: 10px;
            background: rgba(0,0,0,0.5);
            border-left: 3px solid #ff0;
            font-size: 0.9em;
            word-break: break-all;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        
        @keyframes typeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
                opacity: 1;
            }
            20%, 22%, 24%, 55% {
                opacity: 0.5;
            }
        }
        
        @keyframes border-flicker {
            0% { box-shadow: 0 0 5px var(--matrix-green); }
            100% { box-shadow: 0 0 20px var(--matrix-green); }
        }
        
        .hint {
            font-size: 0.8em;
            color: #0f04;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <canvas id="matrix"></canvas>
    
    <div class="container">
        <h1>CTF CYSCOM SQLI</h1>
        
        <div class="terminal-line">
            > Pastikan baca soal dengan benar bank!!!<span class="cursor"></span>
        </div>
        
        <form method="POST" id="loginForm">
            <div class="terminal-line">
                <input type="text" name="username" placeholder="ENTER ADMIN USERNAME" required>
            </div>
            <div class="terminal-line">
                <input type="text" name="password" placeholder="ENTER PASSWORD" required>
            </div>
            <button type="submit">CEK</button>
        </form>
        
        <div class="hint">
            > WARNING : BISA HEK NASA KALO UDAH NEMUIN FLAG!!!
        </div>
        
        <div class="access-denied" id="accessDenied"></div>
        <div id="queryResult"></div>
    </div>

    <script>
        // Matrix background effect
        const canvas = document.getElementById('matrix');
        const ctx = canvas.getContext('2d');
        
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        
        const chars = "01";
        const fontSize = 14;
        const columns = canvas.width / fontSize;
        
        const rainDrops = [];
        
        for (let x = 0; x < columns; x++) {
            rainDrops[x] = 1;
        }
        
        const draw = () => {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#0f0';
            ctx.font = fontSize + 'px monospace';
            
            for (let i = 0; i < rainDrops.length; i++) {
                const text = chars.charAt(Math.floor(Math.random() * chars.length));
                ctx.fillText(text, i * fontSize, rainDrops[i] * fontSize);
                
                if (rainDrops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                    rainDrops[i] = 0;
                }
                rainDrops[i]++;
            }
        };
        
        setInterval(draw, 30);
        
        // Form submission effect
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const button = this.querySelector('button');
            button.disabled = true;
            button.innerHTML = "AUTHENTICATING...";
            
            // Submit form programmatically after delay
            setTimeout(() => {
                this.submit();
            }, 1500);
        });
    </script>
</body>
</html>
