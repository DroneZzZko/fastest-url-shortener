<?php


class UrlTest extends TestCase
{
    /**
     * @return void
     */
    public function testStruture(): void
    {
        $this->post('/', ['url' => 'https://example.com/']);

        $this->response->assertJsonStructure(['newUrl']);
        $hash = $this->getUrlHash();
        $this->assertGreaterThanOrEqual(
            config('short_url')['length'],
            strlen($hash)
        );

        $this->assertTrue(ctype_alnum($hash));
    }

    /**
     * @return void
     */
    public function testExpiration(): void
    {
        config(['short_url.lifetime' => -1]);

        $this->post('/', ['url' => 'https://example.com']);
        $hash = $this->getUrlHash();

        $this->get("/{$hash}");
        $this->response->assertNotFound();
    }

    /**
     * @return void
     */
    public function testRedirect(): void
    {
        $this->post('/', ['url' => 'https://example.com/']);

        $hash = $this->getUrlHash();

        $this->get("/{$hash}");
        $this->response->assertRedirect('https://example.com/');
    }

    private function getUrlHash(): string
    {
        [, $hash] = explode(config('app')['url'] . '/', $this->response->getData(true)['newUrl']);
        return $hash;
    }
}
