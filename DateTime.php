<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="container">
        date: <span id="date"></span>
    </div>




    <script>
        setInterval(func, 1000);

        function func() {
            var now = new Date();
            var dateString = now.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById("date").innerHTML = dateString;
            document.getElementById("container").style.backgroundColor = getRandomColor();
            document.getElementById("date").style.color = getRandomColor();
            document.getElementById("container").style.color = getRandomColor();
        }

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>

</body>

</html>