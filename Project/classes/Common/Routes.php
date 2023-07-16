<?php
    namespace Common;

    interface Routes {
        public function getRoutes(): Array;
        public function getAuthentication(): Authentication;
    }