<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
      <style type="text/tailwindcss">
        @layer utilities {
            .container{
                @apply px-10 mx-auto;
            }
    }
    </style>
    <title>Document</title>

</head>
<body>
    <div class="container">
        <div class="flex justify-between my-5">
            <b><h2 class="text-red-600 text-xl">Request Blood</h2></b>

            <a href="/welcome" class ="bg-green-600 text-white rounded py- 2 px-4">back to bloodConnect</a>
        </div>

        <div>
            <form action="">
                <div class="flex flex col gap-5">
                    <input type="text" name="name">
                    <input type="text" name="description">
                    <input type="file" name="image">
                </div>
                
            </form>
        </div>

        
    </div>
    
</body>
</html>