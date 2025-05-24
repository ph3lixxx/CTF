<?php
// ping.php
header('Content-Type: text/html; charset=utf-8');

$showPopup = false;
$popupMessage = '';
$isSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = hex2bin($_POST['ip'] ?? '');
    
    if (preg_match('/;.*cat.*flag.txt/', $ip)) {
        $popupMessage = "CYSCOM{ph3lixxxjanganlupamewing}";
        $showPopup = true;
        $isSuccess = true;
    } else {
        $output = shell_exec("ping -c 4 " . escapeshellarg($ip));
        $popupMessage = "Error kayak codingan kamwh wkwkk " . htmlspecialchars($ip) . "\n\n" . htmlspecialchars($output);
        $showPopup = true;
        $isSuccess = false;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CTF CYSCOM</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: #000;
            color: #0f0;
            font-family: 'Courier New', monospace;
        }

        #matrix {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .content {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 50px auto;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            text-shadow: 0 0 10px #0f0;
        }

        form {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        input {
            background: #111;
            border: 1px solid #0f0;
            color: #0f0;
            padding: 10px;
            font-family: 'Courier New', monospace;
        }

        button {
            background: #0f0;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        button:hover {
            background: #0c0;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #001100;
            border: 2px solid #0f0;
            padding: 20px;
            max-width: 80%;
            max-height: 80vh;
            overflow: auto;
            box-shadow: 0 0 20px #0f0;
            border-radius: 5px;
        }

        .modal.success .modal-content {
            animation: glow 1s infinite alternate;
        }

        .modal.error .modal-content {
            border-color: #ff0000;
        }

        .modal pre {
            margin: 0;
            padding: 10px;
            background: #000;
        }

        .modal button {
            background: #0f0;
            color: #000;
            border: none;
            padding: 8px 16px;
            margin-top: 15px;
            cursor: pointer;
            float: right;
        }

        @keyframes glow {
            from { box-shadow: 0 0 10px #0f0; }
            to { box-shadow: 0 0 20px #0f0, 0 0 30px #0f0; }
        }
    </style>
</head>
<body>
    <canvas id="matrix"></canvas>
    
    <div class="content">
        <h1>CTF CYSCOM COMMAND INJECTION</h1>
        <form method="POST">
            <input type="text" name="ip" placeholder="Enter IP address" required>
            <button type="submit">Ping</button>
        </form>
 	<small style="color: #0f0; text-align: center; display: block; margin-top: 5px;">
        KALO BISA NYELESAIN FIX BISA GESER PLANET!!
    </small>
    </div>

    <?php if ($showPopup): ?>
    <div class="modal <?php echo $isSuccess ? 'success' : 'error'; ?> active">
        <div class="modal-content">
            <pre><?php echo $popupMessage; ?></pre>
            <button onclick="closeModal()">CLOSE</button>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Matrix rain effect
        const canvas = document.getElementById('matrix');
        const ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%^&*()';
        const drops = [];
        const fontSize = 14;
        const columns = canvas.width/fontSize;

        for(let x = 0; x < columns; x++) {
            drops[x] = 1;
        }

        function draw() {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#0F0';
            ctx.font = fontSize + 'px monospace';

            for(let i = 0; i < drops.length; i++) {
                const text = chars[Math.floor(Math.random() * chars.length)];
                ctx.fillText(text, i*fontSize, drops[i]*fontSize);
                
                if(drops[i]*fontSize > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }
                drops[i]++;
            }
        }

        setInterval(draw, 50);

        // Modal control
        function closeModal() {
            document.querySelector('.modal').classList.remove('active');
        }

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>
