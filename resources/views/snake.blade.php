<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <style>
        body { background: #f4f4f4; font-family: sans-serif; display: flex; flex-direction: column; align-items: center; }
        #snake-canvas { background: #eee; margin-top: 40px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
        .info { margin-top: 10px; color: #555; }
    </style>
</head>
<body>
    <h1>Snake Game</h1>
    <canvas id="snake-canvas" width="320" height="320"></canvas>
    <div class="info">Use arrow keys to play</div>
    <script>
        const canvas = document.getElementById('snake-canvas');
        const ctx = canvas.getContext('2d');
        const grid = 16;
        let count = 0;
        let snake = { x: 160, y: 160, cells: [], maxCells: 4, dx: grid, dy: 0 };
        let apple = { x: 320, y: 320 };
        let score = 0;

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }

        function resetGame() {
            snake.x = 160;
            snake.y = 160;
            snake.cells = [];
            snake.maxCells = 4;
            snake.dx = grid;
            snake.dy = 0;
            apple.x = getRandomInt(0, 20) * grid;
            apple.y = getRandomInt(0, 20) * grid;
            score = 0;
        }

        function loop() {
            requestAnimationFrame(loop);
            if (++count < 4) return;
            count = 0;
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            snake.x += snake.dx;
            snake.y += snake.dy;

            if (snake.x < 0 || snake.x >= canvas.width || snake.y < 0 || snake.y >= canvas.height) {
                resetGame();
            }

            snake.cells.unshift({ x: snake.x, y: snake.y });
            if (snake.cells.length > snake.maxCells) snake.cells.pop();

            // Draw apple
            ctx.fillStyle = '#f53003';
            ctx.fillRect(apple.x, apple.y, grid-1, grid-1);

            // Draw snake
            ctx.fillStyle = '#1b1b18';
            snake.cells.forEach((cell, idx) => {
                ctx.fillRect(cell.x, cell.y, grid-1, grid-1);
                // Snake eats apple
                if (cell.x === apple.x && cell.y === apple.y) {
                    snake.maxCells++;
                    score++;
                    apple.x = getRandomInt(0, 20) * grid;
                    apple.y = getRandomInt(0, 20) * grid;
                }
                // Snake eats itself
                for (let i = idx + 1; i < snake.cells.length; i++) {
                    if (cell.x === snake.cells[i].x && cell.y === snake.cells[i].y) {
                        resetGame();
                    }
                }
            });

            // Draw score
            ctx.fillStyle = '#706f6c';
            ctx.font = '16px sans-serif';
            ctx.fillText('Score: ' + score, 8, 20);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && snake.dx === 0) {
                snake.dx = -grid; snake.dy = 0;
            } else if (e.key === 'ArrowUp' && snake.dy === 0) {
                snake.dy = -grid; snake.dx = 0;
            } else if (e.key === 'ArrowRight' && snake.dx === 0) {
                snake.dx = grid; snake.dy = 0;
            } else if (e.key === 'ArrowDown' && snake.dy === 0) {
                snake.dy = grid; snake.dx = 0;
            }
        });

        resetGame();
        requestAnimationFrame(loop);
    </script>
</body>
</html>