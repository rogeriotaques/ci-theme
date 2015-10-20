# CI Theme 1.4 beta

Provides a simple way to implement a theme based website or app using Codeigniter.

## Getting Started

Download this project, and copy its content into your Codeigniter app, under ```application``` folder.

For example:


```

   / (project root directory)
   /application
   --/config
   --/libraries
   --/themes
   -- ...

```

### Config

There are some basic settings that you can change.

All these settings are located on ```./application/config/theme.php```

```

// --------------------------------------------
// The varname that you'll call on
// your files to output the processed content.
// --------------------------------------------
$config['output_var_name'] = 'outputs';

// --------------------------------------------
// Where theme files are placed ...
// --------------------------------------------
$config['theme_path'] = '../themes/';


```

### Theme file

Create your theme file such as ...

I.e: ```./application/themes/mytheme.php```

```

    <!DOCTYPE html>

    <html>
        <head>
            <title >Sample Theme for CI-Theme</title>
            <link href="images/favicon.ico" rel="icon" type="image/x-icon" >
        </head>
        <body >
            <?php echo $outputs; # here goes the content ... ?>
        </body>
    </html>

```

### Calling a themed page

It's very simple. Have a look:

```

    $ci =& get_instance();
    $ci->load->library('theme');
    $ci->theme->load('mytheme', 'path/to/view');

```

In the same way you can pass other parameters when loading a default codeigniter view file, you can pass another 2 additional params here.

```

    $ci->theme->load('mytheme', 'path/to/view', $vars, FALSE);

```

The third parameter should be an Array with all variables that you want to forward to view.

The fourth parameter, if TRUE, ensure that return won't be outputed for browser, but will be returned as string instead.

## Methods

There some methods that can be used:

### set( name : string, value : array ) : void

Sets a new variable data to be passed for theme output.

### load( theme : string, view : string, view_data : array, return : boolean ) : void|string

Loads a view with a given theme.

### theme::set_css( css : string|array ) : void

It's a static method.

Sets CSS files to be outputed into theme files.

### theme::set_js( js : string|array ) : void

It's a static method.

Sets JS files to be outputed into theme files.

### theme::get_css( inline : boolean ) : array|string

It's a static method.

Get a list of CSS files.

When inline param is TRUE, returns a string with all file names concatenated with comma (,).

I.e:

```
    path/to/file1,path/to/file2, ...
```

### theme::get_js( inline : boolean ) : array|string

It's a static method.

Get a list of JS files.

When inline param is TRUE, returns a string with all file names concatenated with comma (,).

I.e:

```
    path/to/file1,path/to/file2, ...
```

### theme::set_metatag( element : array ) : void

It's a static method.

The CI-Theme allows you to manage the metatags that are placed into your HTML file.

There are already a bunch of predefined metatags that you can use.

This method set those metatags.

The format of given element should be array( tag => '', content => '' ) and supported tags are:

    * name
    * property
    * http-equiv

I.e:

```

    Theme::set_metatag( array('name' => 'robots', 'content' => 'all') ); // or
    Theme::set_metatag( array('property' => 'og:title', 'content' => 'My Title') ); // or
    Theme::set_metatag( array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8') );

```

### theme::set_title( str : string ) : void

It's a static method.

Set the metatag title.

### theme::set_description( str : string ) : void

It's a static method.

Set the metatag description.

### theme::set_keywords( piece : string|array ) : void

It's a static method.

Set the metatag keywords.

### theme::set_author( str : string ) : void

It's a static method.

Set the metatag author.

### theme::set_publisher( str : string ) : void

It's a static method.

Set the metatag publisher.


### theme::set_generator( str : string ) : void

It's a static method.

Set the metatag generator.


### theme::set_canonical( str : string ) : void

It's a static method.

Set the link rel canonical.

It is very useful to let search engines know whenever your page is a variation from an original source within your site.


### theme::set_robots( piece : string|array ) : void

It's a static method.

Set the metatag robots.


### theme::set_opengraph( property : string, content : string) : void

It's a static method.

Set metatags for Open Graph.


### theme::set_fb_opengraph( property : string, content : string) : void

It's a static method.

Set metatags for Facebook Open Graph.


### theme::metatags( void ) : string

It's a static method.

Retrieve a string with all set metatags.


```

    <?php echo Theme::metatag();  ?>

```

And the result should be something like:

```
    <title>Your title here</title>
    <meta name="description" content="..." >
    <meta name="keywords" content="..." >
    <meta name="author" content="..." >
    <meta name="publisher" content="..." >
    <meta name="generator" content="..." >
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" >
    <meta name="robots" content="all" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <meta http-equiv="Content-Style-Type" content="text/css" >
    <meta property="og:title" content="..." >
    <meta property="og:description" content="..." >
    <meta property="og:name" content="..." >
    <meta property="og:image" content="..." >
    <meta property="og:site_name" content="..." >
    <meta property="og:url" content="..." >

```


## Get involved

Report bugs, make suggestions and get involved on contributions.

Feel free to get in touch. ;)

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/rogeriotaques/ci-theme/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
