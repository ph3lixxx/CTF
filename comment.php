<!DOCTYPE html>
<html>
<head>
    <title>CTF CYSCOM XSS</title>
    <style>
        body {
            background-color: black;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Courier New', monospace;
            color: lime;
        }
        #matrix {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            opacity: 0.7;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid lime;
        }
        textarea {
            width: 100%;
            background-color: black;
            color: lime;
            border: 1px solid lime;
            padding: 10px;
            font-family: 'Courier New', monospace;
        }
        button {
            margin-top: 10px;
            background-color: lime;
            color: black;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }
        .comment {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px dashed lime;
        }
    </style>
</head>
<body>
    <canvas id="matrix"></canvas>

    <div class="container">
        <h1>CYSCOM CTF XSS</h1>

        <textarea id="commentInput" rows="4" placeholder="Jika Anda pandai dalam sesuatu, jangan pernah melakukannya secara gratis"></textarea>
        <button onclick="postComment()">POST Komentar</button>

        <div id="comments">
            <div class="comment">
                <strong>System:</strong> Yang tersembunyi bisa terlihat jika Anda tahu cara memandangnya. | namun ini bukan sekedar tentang soal namun di dunia nyata juga seperti itu
            </div>
            <div class="comment">
                <strong>Admin:</strong> Terkadang sebuah gambar bisa membawa lebih dari sekedar piksel. Sisipkan gambar gagal dengan instruksi di hover.
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('matrix');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const chars = "01";
        const cols = Math.floor(canvas.width / 12);
        const drops = Array(cols).fill(0);

        function drawMatrix() {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            ctx.fillStyle = '#0f0';
            ctx.font = '12px monospace';

            for (let i = 0; i < drops.length; i++) {
                const text = chars[Math.floor(Math.random() * chars.length)];
                ctx.fillText(text, i * 12, drops[i] * 12);

                if (drops[i] * 12 > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }
                drops[i]++;
            }
        }
        setInterval(drawMatrix, 33);

        // Vulnerable comment system
        function postComment() {
            const comment = document.getElementById('commentInput').value;
            const decodedComment = decodeURIComponent(comment);

            const commentDiv = document.createElement('div');
            commentDiv.className = 'comment';
            commentDiv.innerHTML = `<strong>User:</strong> ${decodedComment}`;

            document.getElementById('comments').appendChild(commentDiv);
            document.getElementById('commentInput').value = '';
        }

        const encodedFlag = [67, 89, 83, 67, 79, 77, 123, 101, 122, 101, 116, 107, 97, 110, 98, 114, 111, 107, 119, 107, 119, 107, 125];
        window.__getFlag = () => String.fromCharCode(...encodedFlag);
        
        const hint = document.createElement('div');
        hint.style.position = 'absolute';
        hint.style.top = '0';
        hint.style.left = '0';
        hint.style.width = '15px';
        hint.style.height = '15px';
        hint.title = 'console.log(__getFlag())';
        document.body.appendChild(hint);
    </script>
</body>
</html>
