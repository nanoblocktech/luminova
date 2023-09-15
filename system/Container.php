<?php
class Container {
    private $bindings = [];

    public function singleton($abstract, $concrete) {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'instance' => null,
            'isSingleton' => true,
        ];
    }

    public function make($abstract) {
        if (isset($this->bindings[$abstract])) {
            $binding = $this->bindings[$abstract];

            if ($binding['isSingleton'] && $binding['instance'] !== null) {
                return $binding['instance'];
            }

            if (is_callable($binding['concrete'])) {
                $instance = $binding['concrete']();
            } else {
                $instance = new $binding['concrete'];
            }

            if ($binding['isSingleton']) {
                $binding['instance'] = $instance;
            }

            return $instance;
        }

        throw new Exception("Binding for '$abstract' not found.");
    }
}

/*
// Generate and store the CSRF token
CsrfToken::storeToken();

// Retrieve the CSRF token
$token = CsrfToken::getToken();

// Output the CSRF token as a hidden input field in a form
CsrfToken::inputToken();

// Validate the submitted CSRF token
if (CsrfToken::validateToken($submittedToken)) {
    // Token is valid, proceed with form processing
    // Refresh the CSRF token for the next submission
    //Also update form
    CsrfToken::storeToken();
} else {
    // Token is invalid, handle the error
}

*/

// Usage
$container = new Container();

$container->singleton(CsrfToken::class, function () {
    return new CsrfToken();
});

$csrfToken = $container->make(CsrfToken::class);
