<?php

namespace ZakariaTlilani\TranslationManager\Resources\LanguageLineResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Spatie\TranslationLoader\LanguageLine;
use ZakariaTlilani\TranslationManager\Resources\LanguageLineResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class ListLanguageLines extends ListRecords
{
    protected static string $resource = LanguageLineResource::class;

    public function getTranslationPreview($record, $maxLength = null)
    {
        $transParameter = "{$record->group}.{$record->key}";
        $translated = trans($transParameter);

        if ($maxLength) {
            $translated = (strlen($translated) > $maxLength) ? substr($translated, 0, $maxLength) . '...' : $translated;
        }

        return $translated;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false)
                ->label('translation-manager::translations.new-translation')
                ->form([
                    TextInput::make('group')->required(),
                    TextInput::make('key')->required(),

                    Repeater::make('translations')
                        ->schema([
                            Select::make('language')
                                ->options(
                                    collect(\ZakariaTlilani\TranslationManager\TranslationManagerPlugin::get()->getAvailableLocales())
                                        ->pluck('name', 'code')
                                        ->toArray()
                                )->label('translation-manager::translations.Language')
                                ->required(),

                            Textarea::make('text'),
                        ]),
                ])
                ->using(function (array $data) {
                    return LanguageLine::create([
                        'group' => $data['group'],
                        'key'   => $data['key'],
                        'text'  => collect($data['translations'])
                            ->mapWithKeys(fn($item) => [
                                $item['language'] => $item['text'],
                            ])
                            ->all(),
                    ]);
                })
        ];
    }
}
