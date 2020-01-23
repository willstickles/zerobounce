<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Laravel</title>

    </head>
    <body>
        <div id="app">
            <router-view></router-view>

            <hr>

            <router-link :to="{name: 'home'}">Home</router-link>
            <router-link :to="{name: 'login'}">Login</router-link>
            <router-link :to="{name: 'register'}">Register</router-link>

        </div>
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /c/Code/laravel-neutrino/resources/views/welcome.blade.php ENDPATH**/ ?>