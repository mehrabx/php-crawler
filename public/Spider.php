<?php


class Spider
{

    public $url;
    public $sleep;
    public $result;

    public function __construct(
        $url, $sleep
    )
    {
        $this->url = $url;
        $this->sleep = $sleep;
    }

    public function setPropertiesWithBuilder(CrawlBuilder $builder)
    {
        $this->url = $builder->url;
        $this->selector = $builder->selector;
        $this->defaultSelect = $builder->defaultSelect;
        $this->sleep = $builder->sleep;
        $this->exportType = $builder->exportType;

        return $this;
    }

    public function getContent($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
        //        return file_get_contents($this->url);
    }

    public function search(SelectInterface $selectClass)
    {

        if (is_array($this->url))
            foreach ($this->url as $url => $selectors) {

                if (is_null($url)){ $url = $selectors; $selectors=null; }

                $content = $this->getContent($url);
                $this->result[$url] = $selectClass->filter($content, $selectors);
                $this->sleep();
            }

        var_dump($this->result);
//        return $this->result;
    }

    public function sleep()
    {
        return $this->sleep == 0 ? null : sleep($this->sleep);
    }

}
