<?php

\Cake\Routing\Router::scope('/github', ['plugin' => 'CvoTechnologies/GitHub'], function (\Cake\Routing\RouteBuilder $routeBuilder) {
   $routeBuilder->fallbacks();
});
