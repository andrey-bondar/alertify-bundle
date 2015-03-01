AvAlertifyBundle
=============

What is the point ?
-------

This bundle allows you to easily harmonize alerts and others notifications.
Declare in the config (or just use the default configuration) and dispatch alerts with the following libraries ([or your own](#use-my-own-alert-system)):

* TwitterBootstrap (http://twitter.github.com/bootstrap/javascript.html#modals) or
* Noty (http://needim.github.com/noty/) or
* Toastr (https://github.com/CodeSeven/toastr)


Installation
------------

First, require it thanks to composer:

    composer.phar require bestmodules/alertify-bundle:dev-master


Add it in your AppKernel.php:

    public function registerBundles() {
        $bundles = array(
            [...]
            new AppVentus\AlertifyBundle\AvAlertifyBundle(),
            [...]

Then, just publish your assets, annnnnnd it's done !

Configuration
------------


To define the default configuration of your alerts, you can add the following lines in your config.yml :

```yml
av_alertify:
    contexts:
        front:
            engine: "toastr"              \#Could be noty, modal, toastr, alert or your own
            layout: "top-right"           \#Is relative according to the selected engine
            translationDomain: "messages" \#Where do you want to store the translation strings
        admin:
            engine: "myOwnSystem"
            layout: "bottomRight"
            translationDomain: "messages"
```

By default, even if you do not declare any context, Alertify setup default values. You can override these settings easily like this:

 ```yml
av_alertify:
    default:
        context: app                \#default: front
        engine: noty                \#default: toastr
        layout: bottomLeft          \#default: top-right
        translationDomain: messages \#default: flash
    contexts:
    ...
```

Usage
------------

It's easy to use, just follow the following:

Add this block at the end of your twig layout:

     {% block alertify %}
        {{ app.session|alertify|raw }}
     {% endblock %}

Now, anywhere, you can put your alert in the flash session and enjoy.

    $this->get('session')->getFlashBag()->add('success', 'ok');
    $this->get('session')->getFlashBag()->add('warning', array('body' => 'ok');
    $this->get('session')->getFlashBag()->add('warning', array('body' => 'ok', 'context' => 'front');

If you have two contexts in your application (front and back for example), I advice you to override these functions in your controller in each side to pass automatic context like this:

```php
    class BaseFrontController
    {
        /**
         * congrat user through flashbag : all happened successfully
         * Will automatically inject context
         * @param string $content
         */
        public function congrat($content)
        {
            $content = array('body' => $content, 'context' => 'front');
            $this->get('av.shortcuts')->congrat($content);
        }
    }
```


<a name="use-my-own-alert-system"></a>Display alerts with a custom library
------------

AvAlertify comes with some libraries to ease use but it's free to you to use custom Library (feel free to make a Pull request, your library could interest community :).
You just have to follow these steps :

```yml
av_alertify:
    contexts:
        front:
            engine: "myOwnSystem"
            layout: "bottomRight" \#it's up to your library
            translationDomain: "messages"
```

Then just override app/Resources/AvAlertifyBundle/views/Modal/**myOwnSystem**.html.twig and add the alert initialization.

Options
------------

### Modal

To call a modal box, just use a flash named 'modal':

    $this->get('session')->getFlashBag()->add("success", array('engine' => 'modal', 'title' => "Wow", 'button_class' => "btn btn-primary btn-large", "body"=> "<div>Some info</div>"));

as you see, you can pass some arguments tu customize the modal, availables ones are:

    title:
      (html) string
    button-class:
      you con specify classes to customize your button
    body:
      html string
    hasHeader:
      boolean (default = true)
    hasFooter:
      boolean (default = true)
    deleteIcon:
      string : icon-class (for example: "fa fa-times")
    id:
      string : (default: "alertify-modal")


Callback type
------------

There is a final type of Alert you can call, the callback
Callbach allow you to call any action in you project, thats awesome if you want put dynamic content in your alery.
To work, the called action have to render a view. It's very usefull to include a form in a modal for exemple.

    $this->get('session')
      ->getFlashBag()
      ->set('callback', array(
          'engine' => 'modal',
          'title' => 'Wow',
          'action' => 'AcmeBundle:Default:hello',
          'button_class' => 'btn btn-primary btn-large',
          'body' => '<p>Yeah that's crazy !</p>'
        )
    );

This type is very simple to use, just call the callback alery, and in the options define "type" with the final alert you want, the action with the action you want call, and other options specific to the alery you choose.

Ajax mode
-----------

We told you to add the alertify filter in your layout. This is great but what if you want to use ajax in your application ?

Actually, this library is not really made for it but you can simply add this part of code to trigger alerts in your new ajax content :


    {% if app.request.isXmlHttpRequest %}
        {{ app.session|alertify|raw }}
    {% endif %}


Confirm modal
------------

After a link's clic or form's submission, we sometimes want to prompt the user to be sure he understood what he did.
You can make it as a simply way by following the doc here : (https://github.com/AppVentus/AvAlertifyBundle/blob/master/README_Confirm.md)
