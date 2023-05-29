<?php

namespace App\Library\Api\News;

use Illuminate\Support\Arr;

class TransformedArticle
{
    private array|null $source = null;
    private string|null $author = null;
    private string $title;
    private string|null $description = null;
    private string $urlArticle;
    private string|null $urlThumbnail = null;
    private int $publishedAt;

    /**
     * @param string|null $name
     * @param string|null $id
     */
    public function setSource(string $name = null, string $id = null): void
    {
        if(!$name && !$id){
            return;
        }

        $this->source = [
            'name' => $name,
            'id' => $id
        ];
    }


    /**
     * @param string|null $author
     */
    public function setAuthor(string|null $author): void
    {
        $this->author = $author;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(string|null $description): void
    {
        if(!$description)
            return;
        $this->description = mb_convert_encoding(substr($description, 0, 300).'...', 'UTF-8', 'UTF-8');
    }


    /**
     * @param string $urlArticle
     */
    public function setUrlArticle(string $urlArticle): void
    {
        $this->urlArticle = $urlArticle;
    }

    /**
     * @param string|null $urlThumbnail
     */
    public function setUrlThumbnail(string|null $urlThumbnail): void
    {
        $this->urlThumbnail = $urlThumbnail;
    }

    /**
     * @param string $publishedAt
     */
    public function setPublishedAt(string $publishedAt): void
    {
        $this->publishedAt = strtotime($publishedAt);
    }

    public function __toArray(): array
    {
        return [
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'urlArticle' => $this->urlArticle,
            'urlThumbnail' => $this->urlThumbnail,
            'publishedAt' => $this->publishedAt
        ];
    }

}
