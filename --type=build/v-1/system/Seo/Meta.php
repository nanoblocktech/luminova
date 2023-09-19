<?php
namespace Luminova\Seo;  
use \Luminova\BaseController;
class Meta{
    private $link;
    private $app;
    private $manifest;
    private $defaultConfig = [];
    private $extendedConfig = array();
    public function __construct(BaseController $app)
    {
        $this->app = $app;
        $this->manifest = $this->app->readManifest();
        $this->link = $this->app->config::baseUrl();
        $this->setDefaultConfig();
    }
    
    private function setDefaultConfig(): void
    {
        $this->defaultConfig = [
            "link" => $this->manifest->start_url,
            "canonical" => $this->link,
            "previous_page" => "",
            'assets' => $this->manifest->image_assets,
            'company' => "Company",
            "company_name" => $this->manifest->company_name,
            "description" => $this->manifest->description,
            "company_description" => $this->manifest->company_description,
            "title" => $this->manifest->title,
            "caption" => $this->manifest->title,
            "image_name" => $this->manifest->image_name,
            "image_width" => $this->manifest->image_width,
            "image_height" => $this->manifest->image_height,
            "image_type" => $this->manifest->image_type,
            "datePublished" => $this->manifest->datePublished,
            "dateModified" => $this->manifest->dateModified,
            "keywords" => $this->manifest->keywords,
            "isArticle" => false,
            "article_keywords" => [],
            "article_category" => "",
            "author" => "Author Name",
            "twitter_name" => $this->manifest->twitter_name,
        ];
    }
    
    private function toDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        $iso8601Datetime = $dateTime->format('Y-m-d\TH:i:sP');
        return $iso8601Datetime;
    }

    private function getConfig(string $key): string
    {
        $config = array_replace($this->defaultConfig, array_filter($this->extendedConfig));
        $param = ($config[$key]??null);

        if($this->shouldAddParam($key, $param)){
            $param .= "?{$this->getQuery()}";
        }
        $value = is_array($param) ? $param: rtrim($param, "/");
        if($key == "assets"){
            return "{$value}/";
        }
        return $value;
    }

    private function shouldAddParam(string $key, string $param): bool 
    {
        return (in_array($key, ["link", "canonical"]) && !$this->has_query_parameter($param) && !empty($this->getQuery()));
    }

    private function getQuery(): string 
    {
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        return $queryString;
    }

    public function setConfig(array $config): void 
    {
        $this->extendedConfig = $config;
    }

    public function setTitle(string $title): void 
    {
        $this->setPageTitle($title);
    }

    public function setCanonical(string $canonical): void 
    {
        $this->defaultConfig["canonical"] = $canonical;
        $this->defaultConfig["link"] = $canonical;
    }

    public function setPageTitle(string $title): void 
     {
        $appName = $this->app->config::appName();
        if (strpos($title, "| {$appName}") === false) {
            $this->defaultConfig["title"] = "{$title} | {$appName}";
        } else {
            $this->defaultConfig["title"] = $title;
        }
    }

    public function toKebabCase(string $string): string 
    {
        $string = str_replace([' ', ':', '.', ',','-'], '', $string);
        $kebabCase = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string);
        return strtolower($kebabCase);
    }

    public function setLink(string $link): void{
        $this->defaultConfig["link"] = $link;
    }
    
    public function generateScheme(): array{
        $previous_page = strtolower($this->getConfig("previous_page"));
        $schema = [
            "@context" => "https://schema.org",
            "@graph" => [
                0 => [
                    "@type" => "Organization",
                    "@id" => "{$this->manifest->site_id}/#organization",
                    "name" => $this->getConfig("company"),
                    "url" => $this->link . "/",
                    "sameAs" => (array) $this->manifest->social_media,
                    "logo" => [
                        "@type" => "ImageObject",
                        "inLanguage" => $this->manifest->locale,
                        "@id" => "{$this->manifest->site_id}/#logo",
                        "url" => $this->getConfig("assets") . $this->manifest->logo_image_name,
                        "contentUrl" => $this->getConfig("assets") . $this->manifest->logo_image_name,
                        "width" => $this->manifest->logo_image_width,
                        "height" => $this->manifest->logo_image_height,
                        "caption" => $this->getConfig("caption")
                    ],
                    "image" => [
                        "@id" => "{$this->manifest->site_id}/#logo"
                    ]
                ],
                1 => [
                    "@type" => "WebSite",
                    "@id" => "{$this->manifest->site_id}/#website",
                    "url" => $this->link . "/",
                    "name" => $this->getConfig("company"),
                    "description" => $this->getConfig("company_description"),
                    "publisher" => [
                        "@id" => "{$this->manifest->site_id}/#organization"
                    ],
                    "potentialAction" => [
                        [
                            "@type" => "SearchAction",
                            "target" => [
                                "@type" => "EntryPoint",
                                "urlTemplate" => $this->link . "/?s={search_term_string}"
                            ],
                            "query-input" => "required name=search_term_string"
                        ]
                    ],
                    "inLanguage" => $this->manifest->locale
                ],
                2 => [
                    "@type" => "WebPage",
                    "@id" => $this->getConfig("link") . "/#webpage",
                    "url" => $this->getConfig("link"),
                    "name" => $this->getConfig("title"),
                    "isPartOf" => [
                        "@id" => "{$this->manifest->site_id}/#website"
                    ],
                    "about" => [
                        "@id" => $this->getConfig("link") . "/#about"
                    ],
                    "primaryImageOfPage" => [
                        "@id" => $this->getConfig("link") . "/#primaryimage"
                    ],
                    "image" => [
                        "@id" => $this->getConfig("link") . "/#primaryimage"
                    ],
                    "thumbnailUrl" => $this->getConfig("assets") . $this->getConfig("image_name"),
                    "datePublished" => $this->toDate($this->getConfig("datePublished")),
                    "dateModified" =>  $this->toDate($this->getConfig("dateModified")),
                    "description" => $this->getConfig("description"),
                    "breadcrumb" => [
                        "@id" => $this->getConfig("link") . "/#breadcrumb"
                    ],
                    "inLanguage" => $this->manifest->locale,
                    "potentialAction" => [
                        "@type" => "ReadAction",
                        "target" => [
                            $this->getConfig("link")
                        ]
                    ]
                ],
                3 => [
                    "@type" => "ImageObject",
                    "inLanguage" => $this->manifest->locale,
                    "@id" => $this->getConfig("link") . "/#primaryimage",
                    "url" => $this->getConfig("assets") . $this->getConfig("image_name"),
                    "contentUrl" => $this->getConfig("assets") . $this->getConfig("image_name"),
                    "width" => $this->getConfig("image_width"),
                    "height" => $this->getConfig("image_height")
                ], 
                4 => [
                    "@type" => "BreadcrumbList",
                    "@id" => $this->getConfig("link") ."/#breadcrumb",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                           // "nextItem" => $this->link . $this->getConfig("previous_page") . "/#listItem",
                            "item" => [
                                "@type" => "WebPage",
                                "@id" => $this->manifest->site_id,
                                "name" => "Home",
                                "description" => $this->getConfig("company_description"),
                                "url" => $this->link
                            ]
                        ]
                    ]
                ] 
            ]
        ];

        if($this->getConfig("isArticle")){
            if(!empty($this->getConfig("previous_page"))){
                $schema["@graph"][4]["itemListElement"][] = [
                    "@type" => "ListItem",
                    "position" => 2,
                    "nextItem" => $this->getConfig("link") . "/#listItem",
                    "previousItem" => "{$this->manifest->site_id}/#listItem",
                    "item" => [
                        "@type" => "WebPage",
                        "@id" =>  "{$this->manifest->site_id}/" . $previous_page,
                        "name" => ucfirst($previous_page),
                        "description" => $this->getConfig("company_description"),
                        "url" => "{$this->link}/" . $previous_page
                    ]
                ];
            }
            $schema["@graph"][] = [
                "@type" => "Article",
                "@id" => "{$this->getConfig("link")}/#article",
                "isPartOf" => [
                    "@id" => "{$this->getConfig("link")}/#webpage"
                ],
                "author" => [
                    "@type" => "Person",
                    "@id" => "{$this->manifest->site_id}/#/schema/person/{$this->toKebabCase($this->getConfig("author"))}",
                    "name" => $this->getConfig("author"),
                    "image" => [
                        "@type" => "ImageObject",
                        "@id" => "{$this->manifest->site_id}/author/{$this->toKebabCase($this->getConfig("author"))}/#personlogo",
                        "inLanguage" => $this->manifest->locale,
                        "url" => $this->getConfig("assets") . "logo-square-dark.png",
                        "contentUrl" => $this->getConfig("assets") . "logo-square-dark.png",
                        "caption" => $this->getConfig("author")
                    ],
                    "url" => "{$this->link}/author/{$this->toKebabCase($this->getConfig("author"))}"
                ],
                "headline" => $this->getConfig("title"),
                "datePublished" => $this->toDate($this->getConfig("datePublished")),
                "dateModified" =>  $this->toDate($this->getConfig("dateModified")),
                "mainEntityOfPage" => [
                    "@id" => "{$this->getConfig("link")}/#webpage"
                ],
                "wordCount" => 7279,
                "commentCount" => 0,
                "publisher" => [
                    "@id" => "{$this->manifest->site_id}/#organization"
                ],
                "image" => [
                    "@id" => "{$this->getConfig("link")}/#primaryimage"
                ],
                "thumbnailUrl" => $this->getConfig("assets") . $this->getConfig("image_name"),
                "keywords" => $this->getConfig("article_keywords"),
                "articleSection" => [$this->getConfig("article_category")],
                "inLanguage" => $this->manifest->locale,
                "potentialAction" => [
                    [
                        "@type" => "CommentAction",
                        "name" => "Comment",
                        "target" => ["{$this->getConfig("link")}/#respond"]
                    ]
                ],
                "copyrightYear" => date("Y", strtotime($this->getConfig("datePublished"))),
                "copyrightHolder" => [
                    "@id" => "{$this->manifest->site_id}/#organization"
                ]
            ];
        }

        $schema["@graph"][4]["itemListElement"][] = [
            "@type" => "ListItem",
            "position" => count($schema["@graph"][4]["itemListElement"])+1,
            "previousItem" => "{$this->link}/{$previous_page}/#listItem",
            "item" => [
                "@type" => "WebPage",
                "@id" => $this->getConfig("link"),
                "name" => $this->getConfig("title"),
                "description" => $this->getConfig("description"),
                "url" => $this->getConfig("link")
            ]
        ];

        return $schema;
    }

    public function getMetaTags(): string 
    {
        $meta = '<meta name="keywords" content="' . $this->getConfig("keywords") . '">
         <meta name="description" content="' . $this->getConfig("description") . '" />';
         if(!empty($this->getConfig("canonical"))){
            $meta .= '<link rel="canonical" href="' . $this->getConfig("canonical") . '" />';
         }
         if($this->getConfig("isArticle")){
            $meta .= '<meta property="article:publisher" content="'.$this->getConfig("company").'" />
            <meta property="article:published_time" content="'.$this->toDate($this->getConfig("datePublished")).'" />
            <meta property="article:modified_time" content="'.$this->toDate($this->getConfig("dateModified")).'" />';
         }
         $meta .= '<meta property="og:locale" content="' .$this->manifest->facebook_local . '" />
         <meta property="og:type" content="website" />
         <meta property="og:title" content="' . $this->getConfig("title") . '" />
         <meta property="og:description" content="' . $this->getConfig("description") . '" />
         <meta property="og:url" content="' . $this->getConfig("link") . '" />
         <meta property="og:site_name" content="' . $this->getConfig("company_name") . '" />
         <meta property="og:image" content="' . $this->getConfig("assets") . $this->getConfig("image_name") . '" />
         <meta property="og:image:width" content="' . $this->getConfig("image_width") . '" />
         <meta property="og:image:height" content="' . $this->getConfig("image_height") . '" />
         <meta property="og:image:type" content="' . $this->getConfig("image_type") . '" />
         <meta name="twitter:card" content="summary" />
         <meta name="twitter:site" content="@' . $this->manifest->twitter_name . '" />
         <meta name="twitter:label1" content="Est. reading time" />
         <meta name="twitter:data1" content="37 minutes" />';
         return $meta;
    }

    public function toJson(): string 
    {
        return json_encode($this->generateScheme(), JSON_UNESCAPED_SLASHES);
    }
    
    public function has_query_parameter(string $url): bool {
        if (strpos($url, '?') === false) {
            return false;
        }
        $path_and_query = explode('?', $url);
        if ($path_and_query[1] === '') {
            return false;
        }
        return true;
    }


    public function getObjectGraph(): string 
    {
        return '<script type="application/ld+json">' . $this->toJson() . '</script>';
    }
}