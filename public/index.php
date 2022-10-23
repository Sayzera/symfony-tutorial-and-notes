<?php

use App\Kernel;
?>
<style>
    .exception-message::after {
        content: " [Niltek Yazılım]";
        text-shadow: 0px 0px 30px rgba(0, 0, 164, 1);
    }

    .exception-message:hover {
        transition: 0.5s;
        text-shadow: 0px 0px 30px rgba(0, 0, 164, 1);
        cursor: pointer;
        scale: 1.1;
    }
</style>
<?php

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};


?>