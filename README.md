# Lets call it Tak Simple Bookkeeper for now

## About Tak Simple Bookkeeper

A simple bookkeeping system for my son who started his very own small business.  
It needed to be simple and straitforward.  
Free and open-source, for freelancers and small businesses. 

Oh, en ja, teksten zijn vooral in het nederlands, voorlopig.  
Oh, and yes, texts are meanly in dutch, or in bad english.  

## Build with

- PHP 8.0.2 & Mysql (I'm using [MAMP](https://www.mamp.info) locally)
- [Tailwind](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev/), [Laravel](https://laravel.com), and [Livewire](https://laravel-livewire.com).


## Installing Tak Simple Bookkeeper


clone the repository  
`git clone https://github.com/StudioTakken/tak-simple-bookkeeper.git`

cd to tak-simple-bookkeeper. Yeah it's in a subfolder...  
`cd tak-simple-bookkeeper/tak-simple-bookkeeper`

copy .env.example to .env  
`cp .env.example .env`

edit .env  
Set `database` 
and the `test admin mail and password` at the end of the file.  
Provide the mail settings. I use mailhug in dev.
Set the `main booking account`, this is the account for importing your bank cvs file.  

composer https://getcomposer.org/ should be installed first to be able to install all dependencies  
`composer install`

setup the database with some presets  
`php artisan migrate:fresh --seed`  

Generate appication key  
`php artisan key:generate`

You'll need npm: https://docs.npmjs.com/  
Then  
`npm install`  

and go:  
`npm run dev`   
or  
`npm run build`  

Now we are ready to serve:  
`php artisan serve`  
or  
point your server to the public folder.

## Using Tak Simple Bookkeeper

Start with the suggestions found on the dashboard page.

## Contributing

That would be great. Fork, develop and send a pull request!

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact

martin@studiotakken.nl