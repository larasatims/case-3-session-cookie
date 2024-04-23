<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- header -->
    <?php include 'header.php'; ?>

    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md bg-white p-8 shadow-lg rounded-lg w-full">
            <div class="font-bold mb-2 text-center text-lg">Please Login</div>
            <form id="loginForm" class="space-y-4" method="post" enctype="multipart/form-data">
                <div>
                    <label for="email" class="block mb-1">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="mr-2">
                    <label for="remember">Remember Me</label>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Login</button>
            </form>
        </div>
        <div id="errorPopup" class="error-message" style="position: fixed; display:none; background-color: red; color: white; padding: 10px; border-radius: 5px;">
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();

                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var remember = document.getElementById('remember').checked;

                // validasi email
                if (!validateEmail(email)) {
                    showError('Invalid email.');
                    return;
                }

                // validasi password
                if (!validatePassword(password)) {
                    showError('Invalid password.');
                    return;
                }

                var formData = new FormData(this);
                var rememberedEmail = getCookie("user_email");
                if (rememberedEmail !== "") {
                    $("#email").val(rememberedEmail);
                }

                fetch('process_login.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (remember) {
                                setCookie("user_email", email, 24); // Cookie berlaku selama 24 jam
                            }
                            window.location.href = 'profile.php'; // redirect ke profile page kalo sukses
                        } else {
                            showError(response); // show error message
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        function validateEmail(email) {
            // validasi email dengan mencari karakter '@' dan '.'
            return /\S+@\S+\.\S+/.test(email);
        }

        function validatePassword(password) {
            // validasi password minimal 8 karakter, dengan kombinasi huruf kecil, huruf besar, angka, dan simbol
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;
            return passwordRegex.test(password);
        }

        function showError(message) {
            var errorPopup = document.getElementById('errorPopup');
            errorPopup.textContent = message;
            errorPopup.style.display = 'flex';
            setTimeout(function() {
                errorPopup.style.display = 'none';
            }, 3000);
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === " ") {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function setCookie(cname, cvalue, exhours) {
            var d = new Date();
            d.setTime(d.getTime() + exhours * 60 * 60 * 1000); // Mengubah ke jam
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    </script>
</body>

</html>