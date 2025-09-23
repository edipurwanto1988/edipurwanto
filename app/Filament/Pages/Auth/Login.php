<?php

namespace App\Filament\Pages\Auth;

use App\Services\MD5AuthService;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected string $captchaSessionKey = 'filament.captcha.answer';

    public string $captchaQuestion = '';

    public string $captchaImage = '';

    public function mount(): void
    {
        parent::mount();

        $this->generateCaptcha();
    }

    protected function generateCaptcha(): void
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        $this->captchaQuestion = sprintf('%d + %d', $a, $b);

        session()->put($this->captchaSessionKey, $a + $b);

        $this->captchaImage = $this->makeCaptchaImage($this->captchaQuestion);

        $state = $this->form->getState();
        $state['captcha'] = null;
        $this->form->fill($state);
    }

    public function form(Schema $schema): Schema
    {
        $schema = parent::form($schema);

        $components = [
            ...$schema->getComponents(),
            TextInput::make('captcha')
                ->label('Captcha')
                ->helperText(function (): HtmlString {
                    $imageHtml = $this->captchaImage
                        ? '<img src="data:image/png;base64,' . $this->captchaImage . '" alt="Captcha" class="h-12 rounded-md border border-slate-200 bg-white" />'
                        : '<span class="text-sm text-slate-500">' . e($this->captchaQuestion) . '</span>';

                    return new HtmlString(
                        '<div class="flex items-center gap-3">'
                        . $imageHtml
                        . '<button type="button" wire:click="refreshCaptcha" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Muat ulang</button>'
                        . '</div>'
                    );
                })
                ->required()
                ->numeric()
                ->maxLength(10),
        ];

        return $schema->components($components);
    }

    public function refreshCaptcha(): void
    {
        $this->generateCaptcha();
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $expected = session()->pull($this->captchaSessionKey);

        if (! is_numeric($expected) || ((int) ($data['captcha'] ?? -1)) !== (int) $expected) {
            $this->generateCaptcha();

            throw ValidationException::withMessages([
                'data.captcha' => 'Jawaban captcha salah, coba lagi.',
            ]);
        }

        try {
            // Use custom MD5 authentication service
            $authService = new MD5AuthService();
            $user = $authService->authenticate($data['email'], $data['password']);
            $authService->login($user);
            
            return app(LoginResponse::class);
        } catch (ValidationException $exception) {
            $this->generateCaptcha();

            throw $exception;
        }
    }

    protected function makeCaptchaImage(string $expression): string
    {
        $width = 140;
        $height = 48;
        $image = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($image, 248, 250, 252);
        $textColor = imagecolorallocate($image, 51, 65, 85);
        $noiseColor = imagecolorallocate($image, 203, 213, 225);

        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        for ($i = 0; $i < 60; $i++) {
            imagesetpixel($image, random_int(0, $width - 1), random_int(0, $height - 1), $noiseColor);
        }

        $x = 18;
        $y = 16;
        imagestring($image, 5, $x, $y, $expression, $textColor);

        ob_start();
        imagepng($image);
        $pngData = ob_get_clean() ?: '';
        imagedestroy($image);

        return base64_encode($pngData);
    }
}
