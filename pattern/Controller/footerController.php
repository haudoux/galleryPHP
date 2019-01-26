<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");

class FooterController
{
    public function __construct()
    {
    }
    public function renderTemplate()
    {
        $html  = $this->renderFooter();
        return $html;
    }
    private function renderFooter()
    {
        echo '
                    </body>
                </html>';
    }
}
