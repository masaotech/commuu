<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="$url">
Button Text
</x-mail::button>

<x-mail::panel>
ここはパネルの本文。
</x-mail::panel>

<x-mail::table>
| Laravel       | テーブル        | 例            |
| ------------- | :-----------: | ------------: |
| Col 2 is      | Centered      | $10           |
| Col 3 is      | Right-Aligned | $20           |
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
