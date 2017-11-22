# Guzzle Base Client

This is a simple base Guzzle Client to quickly consume responses from JSON based services.

## Example usage

The `respond()` will automatically parse out the response from the Guzzle Client so you may quickly interact with it.

```php

<?php

use MatthewErskine\Guzzle\Client;

class FruitService extends Client
{
    public function getFruits()
    {
        // {"data": [{"title": "banana"}, {"title": "apple"}]}
        return $this->respond(
            $this->getHttpClient()->get($this->getUrl().'/bananas')
        );
    }
}

```

Now in a consuming class we can interact with data directly:

```php
<?php

class FruitRepository
{
    ...

    public function giveMeABanana()
    {
        foreach ($this->fruitService->getFruits() as $fruit) {
            if ($fruit['title'] == 'banana') {
                return $fruit;
            }
        }
    }
}

```
