```php
    /**
     * 
     *
     * @param string PDFダウンロードパス
     */
    public function pdfDownload($url)
    {
        if(preg_match("/^http/", $url) !== false){

            $parse  = explode("/", $url);
            $file   = array_pop($parse);
            $dl_url = implode("/", $parse) . "/" . urlencode($file);

            header('Set-Cookie: fileDownload=true; path=/');

            //日本語ファイル名を使用するための対応。
            $path = urlencode($file);
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename*=utf-8'ja'{$path}");
            header('Content-Transfer-Encoding: binary');

            readfile($dl_url);
        }
        else {

            return false;
        }
    }
```
