var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.less([ 
    	'app.less' 
    	], 'public/assets/css/custom'); 

    mix.sass([ 
    	"dt/dtform.scss"
    	],
    	'public/admin/css/dt');
});
