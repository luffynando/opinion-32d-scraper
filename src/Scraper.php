<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use PhpCfdi\ImageCaptchaResolver\CaptchaImage;
use PhpCfdi\ImageCaptchaResolver\CaptchaResolverInterface;
use PhpCfdi\Opinion32dScraper\Contracts\BrowserClientInterface;
use PhpCfdi\Opinion32dScraper\Exceptions\InvalidCaptchaException;
use PhpCfdi\Opinion32dScraper\Exceptions\InvalidCredentialsException;
use PhpCfdi\Opinion32dScraper\Exceptions\PdfDownloadException;
use PhpCfdi\Opinion32dScraper\Exceptions\SatScraperException;
use Throwable;

final readonly class Scraper
{
    public function __construct(
        private Credentials $credentials,
        private CaptchaResolverInterface $captchaResolver,
        private BrowserClientInterface $browserClient,
        private int $timeout = 30
    ) {}

    /**
     * @throws InvalidCaptchaException
     * @throws InvalidCredentialsException
     */
    public function login(): void
    {
        $this->browserClient->get(URL::MAIN_URL);
        try {
            $this->browserClient->waitFor('#tramiteCampo', $this->timeout);
            $this->browserClient->getCrawler()->selectButton('ContraseÃ±a')->click();
            $this->browserClient->waitFor('#divCaptcha', $this->timeout);
        } catch (TimeoutException | NoSuchElementException $exception) {
            throw new SatScraperException(sprintf('The %s page does not load as expected', URL::LOGIN_URL), 0, $exception);
        }

        $captcha = $this->browserClient->getCrawler()
            ->filter('#divCaptcha > img')
            ->first();
        /** @var string $imageSrc */
        $imageSrc = $captcha->attr('src');
        $image = CaptchaImage::newFromInlineHtml($imageSrc);

        $value = $this->captchaResolver->resolve($image);

        $form = $this->browserClient->getCrawler()
            ->selectButton('submit')
            ->form();

        $form->setValues([
            'Ecom_User_ID' => $this->credentials->getRfc(),
            'Ecom_Password' => $this->credentials->getCiec(),
            'userCaptcha' => $value->getValue(),
        ]);

        $this->browserClient->submit($form);

        $html = $this->browserClient->getCrawler()->html();
        if (str_contains($html, 'Captcha no válido')) {
            throw new InvalidCaptchaException('The provided captcha is invalid');
        }

        if (str_contains($html, 'El RFC o contraseña son incorrectos')) {
            throw new InvalidCredentialsException('The provided credentials are invalid');
        }
    }

    public function obtainPdfBase64(): ?string
    {
        $this->browserClient->waitFor('iframe[title="pdfReporteOpinion"]', 120);
        try {
            $iframeSRC = $this->browserClient->getCrawler()->filter('iframe[title="pdfReporteOpinion"]')->attr('src');
        } catch (Throwable $exception) {
            throw new PdfDownloadException('Error getting pdf, server error', 0, $exception);
        }

        // TODO: quitar esta linea cuando ya no lo descargue 2 veces
        @unlink('download.pdf');
        return $iframeSRC;
    }

    public function retrievePdf(): ?string
    {
        $this->login();
        $iframeSRC = $this->obtainPdfBase64();
        $this->logout();
        return $iframeSRC;
    }

    public function logout(): void
    {
        $this->browserClient->waitFor('#navbarTogglerDemo03');
        $logoutLink = $this->browserClient->getCrawler()->selectLink('Cerrar sesión')->link();
        $this->browserClient->get($logoutLink->getUri());
    }
}
