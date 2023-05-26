<?php

namespace App\Library\Api\News;

use Illuminate\Support\Arr;

class TransformedArticle
{


    private array|null $source = null;
    private string|null $author = null;
    private string $title;
    private string $description;
    private string $urlArticle;
    private string|null $urlThumbnail = null;
    private string $publishedAt;

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
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description ? substr($description, 0, 200).'...': null;
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
        $this->publishedAt = $publishedAt;
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
