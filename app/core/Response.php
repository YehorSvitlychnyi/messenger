<?php


namespace app\core;


class Response
{
    /**
     * Default template name
     */
    const DEFAULT_TEMPLATE = 'default';

    /**
     * Views main directory
     */
    const VIEWS_DIR = '../app/views';

    /**
     * Templates views dir
     */
    const VIEWS_TEMPLATE_DIR = '/templates';

    /**
     * Pages views dir
     */
    const VIEWS_PAGES_DIR = '/pages';

    /**
     * Set HTTP response status
     * @param int $statusCode
     */
    public function status(int $statusCode): void
    {
        http_response_code($statusCode);
    }

    /**
     * Set location header
     * @param string $url
     */
    public function redirect(string $url)
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Show view
     * @param string $page
     * @param array $data
     * @param string $template
     * @throws \Exception
     */
    public function view(string $page, array $data = [], string $template = self::DEFAULT_TEMPLATE)
    {
        extract($data);
        $templateFile = $this->getTemplatesDir() . '/' . $template . '_template.php';
        if(!file_exists($templateFile)){
            throw new \Exception('No template file ' . $templateFile);
        }
        $pagePath = $this->getPagesDir() . '/' . $page . '_page.php';
        if(!file_exists($pagePath)){
            throw new \Exception('No page file ' . $pagePath);
        }
        include_once $templateFile;
    }

    /**
     * Return templates dir full path
     * @return string
     */
    private function getTemplatesDir(){
        return self::VIEWS_DIR . self::VIEWS_TEMPLATE_DIR;
    }

    /**
     * Return pages dir full path
     * @return string
     */
    private function getPagesDir(){
        return self::VIEWS_DIR . self::VIEWS_PAGES_DIR;
    }

    public function json(array $data){
        echo json_encode($data);
        header('Content-Type: application/json');
    }
}