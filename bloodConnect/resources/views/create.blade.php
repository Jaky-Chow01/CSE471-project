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
    <nav class="p-6 flex items-center justify-between max-w-7xl mx-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
            <span class="text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

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