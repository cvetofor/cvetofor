@extends('twill::layouts.form')

@section('contentFields')

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Пн</th>
                <th>Вт</th>
                <th>Ср</th>
                <th>Чт</th>
                <th>Пт</th>
                <th>Сб</th>
                <th>Вс</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">с 00:00 до 01:00</td>
                <td>
                    <input type="checkbox" name="times_monday0000" {{ $item->times['monday0000'] ?? false ? 'checked' : '' }}
                        id="times_monday0000" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0000"
                        {{ $item->times['tuesday0000'] ?? false ? 'checked' : '' }} id="times_tuesday0000" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0000"
                        {{ $item->times['wednesday0000'] ?? false ? 'checked' : '' }} id="times_wednesday0000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0000"
                        {{ $item->times['thursday0000'] ?? false ? 'checked' : '' }} id="times_thursday0000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0000"
                        {{ $item->times['friday0000'] ?? false ? 'checked' : '' }} id="times_friday0000" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0000"
                        {{ $item->times['saturday0000'] ?? false ? 'checked' : '' }} id="times_saturday0000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0000"
                        {{ $item->times['sunday0000'] ?? false ? 'checked' : '' }} id="times_sunday0000" label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 01:00 до 02:00</td>
                <td>
                    <input type="checkbox" name="times_monday0100"
                        {{ $item->times['monday0100'] ?? false ? 'checked' : '' }} id="times_monday0100" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0100"
                        {{ $item->times['tuesday0100'] ?? false ? 'checked' : '' }} id="times_tuesday0100" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0100"
                        {{ $item->times['wednesday0100'] ?? false ? 'checked' : '' }} id="times_wednesday0100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0100"
                        {{ $item->times['thursday0100'] ?? false ? 'checked' : '' }} id="times_thursday0100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0100"
                        {{ $item->times['friday0100'] ?? false ? 'checked' : '' }} id="times_friday0100" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0100"
                        {{ $item->times['saturday0100'] ?? false ? 'checked' : '' }} id="times_saturday0100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0100"
                        {{ $item->times['sunday0100'] ?? false ? 'checked' : '' }} id="times_sunday0100" label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 02:00 до 03:00</td>
                <td>
                    <input type="checkbox" name="times_monday0200"
                        {{ $item->times['monday0200'] ?? false ? 'checked' : '' }} id="times_monday0200" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0200"
                        {{ $item->times['tuesday0200'] ?? false ? 'checked' : '' }} id="times_tuesday0200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0200"
                        {{ $item->times['wednesday0200'] ?? false ? 'checked' : '' }} id="times_wednesday0200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0200"
                        {{ $item->times['thursday0200'] ?? false ? 'checked' : '' }} id="times_thursday0200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0200"
                        {{ $item->times['friday0200'] ?? false ? 'checked' : '' }} id="times_friday0200" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0200"
                        {{ $item->times['saturday0200'] ?? false ? 'checked' : '' }} id="times_saturday0200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0200"
                        {{ $item->times['sunday0200'] ?? false ? 'checked' : '' }} id="times_sunday0200" label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 03:00 до 04:00</td>
                <td>
                    <input type="checkbox" name="times_monday0300"
                        {{ $item->times['monday0300'] ?? false ? 'checked' : '' }} id="times_monday0300" label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0300"
                        {{ $item->times['tuesday0300'] ?? false ? 'checked' : '' }} id="times_tuesday0300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0300"
                        {{ $item->times['wednesday0300'] ?? false ? 'checked' : '' }} id="times_wednesday0300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0300"
                        {{ $item->times['thursday0300'] ?? false ? 'checked' : '' }} id="times_thursday0300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0300"
                        {{ $item->times['friday0300'] ?? false ? 'checked' : '' }} id="times_friday0300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0300"
                        {{ $item->times['saturday0300'] ?? false ? 'checked' : '' }} id="times_saturday0300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0300"
                        {{ $item->times['sunday0300'] ?? false ? 'checked' : '' }} id="times_sunday0300"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 04:00 до 05:00</td>
                <td>
                    <input type="checkbox" name="times_monday0400"
                        {{ $item->times['monday0400'] ?? false ? 'checked' : '' }} id="times_monday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0400"
                        {{ $item->times['tuesday0400'] ?? false ? 'checked' : '' }} id="times_tuesday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0400"
                        {{ $item->times['wednesday0400'] ?? false ? 'checked' : '' }} id="times_wednesday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0400"
                        {{ $item->times['thursday0400'] ?? false ? 'checked' : '' }} id="times_thursday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0400"
                        {{ $item->times['friday0400'] ?? false ? 'checked' : '' }} id="times_friday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0400"
                        {{ $item->times['saturday0400'] ?? false ? 'checked' : '' }} id="times_saturday0400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0400"
                        {{ $item->times['sunday0400'] ?? false ? 'checked' : '' }} id="times_sunday0400"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 05:00 до 06:00</td>
                <td>
                    <input type="checkbox" name="times_monday0500"
                        {{ $item->times['monday0500'] ?? false ? 'checked' : '' }} id="times_monday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0500"
                        {{ $item->times['tuesday0500'] ?? false ? 'checked' : '' }} id="times_tuesday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0500"
                        {{ $item->times['wednesday0500'] ?? false ? 'checked' : '' }} id="times_wednesday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0500"
                        {{ $item->times['thursday0500'] ?? false ? 'checked' : '' }} id="times_thursday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0500"
                        {{ $item->times['friday0500'] ?? false ? 'checked' : '' }} id="times_friday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0500"
                        {{ $item->times['saturday0500'] ?? false ? 'checked' : '' }} id="times_saturday0500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0500"
                        {{ $item->times['sunday0500'] ?? false ? 'checked' : '' }} id="times_sunday0500"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 06:00 до 07:00</td>
                <td>
                    <input type="checkbox" name="times_monday0600"
                        {{ $item->times['monday0600'] ?? false ? 'checked' : '' }} id="times_monday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0600"
                        {{ $item->times['tuesday0600'] ?? false ? 'checked' : '' }} id="times_tuesday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0600"
                        {{ $item->times['wednesday0600'] ?? false ? 'checked' : '' }} id="times_wednesday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0600"
                        {{ $item->times['thursday0600'] ?? false ? 'checked' : '' }} id="times_thursday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0600"
                        {{ $item->times['friday0600'] ?? false ? 'checked' : '' }} id="times_friday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0600"
                        {{ $item->times['saturday0600'] ?? false ? 'checked' : '' }} id="times_saturday0600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0600"
                        {{ $item->times['sunday0600'] ?? false ? 'checked' : '' }} id="times_sunday0600"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 07:00 до 08:00</td>
                <td>
                    <input type="checkbox" name="times_monday0700"
                        {{ $item->times['monday0700'] ?? false ? 'checked' : '' }} id="times_monday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0700"
                        {{ $item->times['tuesday0700'] ?? false ? 'checked' : '' }} id="times_tuesday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0700"
                        {{ $item->times['wednesday0700'] ?? false ? 'checked' : '' }} id="times_wednesday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0700"
                        {{ $item->times['thursday0700'] ?? false ? 'checked' : '' }} id="times_thursday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0700"
                        {{ $item->times['friday0700'] ?? false ? 'checked' : '' }} id="times_friday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0700"
                        {{ $item->times['saturday0700'] ?? false ? 'checked' : '' }} id="times_saturday0700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0700"
                        {{ $item->times['sunday0700'] ?? false ? 'checked' : '' }} id="times_sunday0700"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 08:00 до 09:00</td>
                <td>
                    <input type="checkbox" name="times_monday0800"
                        {{ $item->times['monday0800'] ?? false ? 'checked' : '' }} id="times_monday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0800"
                        {{ $item->times['tuesday0800'] ?? false ? 'checked' : '' }} id="times_tuesday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0800"
                        {{ $item->times['wednesday0800'] ?? false ? 'checked' : '' }} id="times_wednesday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0800"
                        {{ $item->times['thursday0800'] ?? false ? 'checked' : '' }} id="times_thursday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0800"
                        {{ $item->times['friday0800'] ?? false ? 'checked' : '' }} id="times_friday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0800"
                        {{ $item->times['saturday0800'] ?? false ? 'checked' : '' }} id="times_saturday0800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0800"
                        {{ $item->times['sunday0800'] ?? false ? 'checked' : '' }} id="times_sunday0800"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 09:00 до 10:00</td>
                <td>
                    <input type="checkbox" name="times_monday0900"
                        {{ $item->times['monday0900'] ?? false ? 'checked' : '' }} id="times_monday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday0900"
                        {{ $item->times['tuesday0900'] ?? false ? 'checked' : '' }} id="times_tuesday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday0900"
                        {{ $item->times['wednesday0900'] ?? false ? 'checked' : '' }} id="times_wednesday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday0900"
                        {{ $item->times['thursday0900'] ?? false ? 'checked' : '' }} id="times_thursday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday0900"
                        {{ $item->times['friday0900'] ?? false ? 'checked' : '' }} id="times_friday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday0900"
                        {{ $item->times['saturday0900'] ?? false ? 'checked' : '' }} id="times_saturday0900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday0900"
                        {{ $item->times['sunday0900'] ?? false ? 'checked' : '' }} id="times_sunday0900"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 10:00 до 11:00</td>
                <td>
                    <input type="checkbox" name="times_monday1000"
                        {{ $item->times['monday1000'] ?? false ? 'checked' : '' }} id="times_monday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1000"
                        {{ $item->times['tuesday1000'] ?? false ? 'checked' : '' }} id="times_tuesday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1000"
                        {{ $item->times['wednesday1000'] ?? false ? 'checked' : '' }} id="times_wednesday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1000"
                        {{ $item->times['thursday1000'] ?? false ? 'checked' : '' }} id="times_thursday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1000"
                        {{ $item->times['friday1000'] ?? false ? 'checked' : '' }} id="times_friday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1000"
                        {{ $item->times['saturday1000'] ?? false ? 'checked' : '' }} id="times_saturday1000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1000"
                        {{ $item->times['sunday1000'] ?? false ? 'checked' : '' }} id="times_sunday1000"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 11:00 до 12:00</td>
                <td>
                    <input type="checkbox" name="times_monday1100"
                        {{ $item->times['monday1100'] ?? false ? 'checked' : '' }} id="times_monday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1100"
                        {{ $item->times['tuesday1100'] ?? false ? 'checked' : '' }} id="times_tuesday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1100"
                        {{ $item->times['wednesday1100'] ?? false ? 'checked' : '' }} id="times_wednesday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1100"
                        {{ $item->times['thursday1100'] ?? false ? 'checked' : '' }} id="times_thursday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1100"
                        {{ $item->times['friday1100'] ?? false ? 'checked' : '' }} id="times_friday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1100"
                        {{ $item->times['saturday1100'] ?? false ? 'checked' : '' }} id="times_saturday1100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1100"
                        {{ $item->times['sunday1100'] ?? false ? 'checked' : '' }} id="times_sunday1100"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 12:00 до 13:00</td>
                <td>
                    <input type="checkbox" name="times_monday1200"
                        {{ $item->times['monday1200'] ?? false ? 'checked' : '' }} id="times_monday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1200"
                        {{ $item->times['tuesday1200'] ?? false ? 'checked' : '' }} id="times_tuesday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1200"
                        {{ $item->times['wednesday1200'] ?? false ? 'checked' : '' }} id="times_wednesday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1200"
                        {{ $item->times['thursday1200'] ?? false ? 'checked' : '' }} id="times_thursday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1200"
                        {{ $item->times['friday1200'] ?? false ? 'checked' : '' }} id="times_friday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1200"
                        {{ $item->times['saturday1200'] ?? false ? 'checked' : '' }} id="times_saturday1200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1200"
                        {{ $item->times['sunday1200'] ?? false ? 'checked' : '' }} id="times_sunday1200"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 13:00 до 14:00</td>
                <td>
                    <input type="checkbox" name="times_monday1300"
                        {{ $item->times['monday1300'] ?? false ? 'checked' : '' }} id="times_monday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1300"
                        {{ $item->times['tuesday1300'] ?? false ? 'checked' : '' }} id="times_tuesday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1300"
                        {{ $item->times['wednesday1300'] ?? false ? 'checked' : '' }} id="times_wednesday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1300"
                        {{ $item->times['thursday1300'] ?? false ? 'checked' : '' }} id="times_thursday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1300"
                        {{ $item->times['friday1300'] ?? false ? 'checked' : '' }} id="times_friday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1300"
                        {{ $item->times['saturday1300'] ?? false ? 'checked' : '' }} id="times_saturday1300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1300"
                        {{ $item->times['sunday1300'] ?? false ? 'checked' : '' }} id="times_sunday1300"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 14:00 до 15:00</td>
                <td>
                    <input type="checkbox" name="times_monday1400"
                        {{ $item->times['monday1400'] ?? false ? 'checked' : '' }} id="times_monday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1400"
                        {{ $item->times['tuesday1400'] ?? false ? 'checked' : '' }} id="times_tuesday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1400"
                        {{ $item->times['wednesday1400'] ?? false ? 'checked' : '' }} id="times_wednesday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1400"
                        {{ $item->times['thursday1400'] ?? false ? 'checked' : '' }} id="times_thursday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1400"
                        {{ $item->times['friday1400'] ?? false ? 'checked' : '' }} id="times_friday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1400"
                        {{ $item->times['saturday1400'] ?? false ? 'checked' : '' }} id="times_saturday1400"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1400"
                        {{ $item->times['sunday1400'] ?? false ? 'checked' : '' }} id="times_sunday1400"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 15:00 до 16:00</td>
                <td>
                    <input type="checkbox" name="times_monday1500"
                        {{ $item->times['monday1500'] ?? false ? 'checked' : '' }} id="times_monday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1500"
                        {{ $item->times['tuesday1500'] ?? false ? 'checked' : '' }} id="times_tuesday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1500"
                        {{ $item->times['wednesday1500'] ?? false ? 'checked' : '' }} id="times_wednesday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1500"
                        {{ $item->times['thursday1500'] ?? false ? 'checked' : '' }} id="times_thursday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1500"
                        {{ $item->times['friday1500'] ?? false ? 'checked' : '' }} id="times_friday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1500"
                        {{ $item->times['saturday1500'] ?? false ? 'checked' : '' }} id="times_saturday1500"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1500"
                        {{ $item->times['sunday1500'] ?? false ? 'checked' : '' }} id="times_sunday1500"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 16:00 до 17:00</td>
                <td>
                    <input type="checkbox" name="times_monday1600"
                        {{ $item->times['monday1600'] ?? false ? 'checked' : '' }} id="times_monday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1600"
                        {{ $item->times['tuesday1600'] ?? false ? 'checked' : '' }} id="times_tuesday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1600"
                        {{ $item->times['wednesday1600'] ?? false ? 'checked' : '' }} id="times_wednesday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1600"
                        {{ $item->times['thursday1600'] ?? false ? 'checked' : '' }} id="times_thursday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1600"
                        {{ $item->times['friday1600'] ?? false ? 'checked' : '' }} id="times_friday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1600"
                        {{ $item->times['saturday1600'] ?? false ? 'checked' : '' }} id="times_saturday1600"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1600"
                        {{ $item->times['sunday1600'] ?? false ? 'checked' : '' }} id="times_sunday1600"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 17:00 до 18:00</td>
                <td>
                    <input type="checkbox" name="times_monday1700"
                        {{ $item->times['monday1700'] ?? false ? 'checked' : '' }} id="times_monday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1700"
                        {{ $item->times['tuesday1700'] ?? false ? 'checked' : '' }} id="times_tuesday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1700"
                        {{ $item->times['wednesday1700'] ?? false ? 'checked' : '' }} id="times_wednesday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1700"
                        {{ $item->times['thursday1700'] ?? false ? 'checked' : '' }} id="times_thursday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1700"
                        {{ $item->times['friday1700'] ?? false ? 'checked' : '' }} id="times_friday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1700"
                        {{ $item->times['saturday1700'] ?? false ? 'checked' : '' }} id="times_saturday1700"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1700"
                        {{ $item->times['sunday1700'] ?? false ? 'checked' : '' }} id="times_sunday1700"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 18:00 до 19:00</td>
                <td>
                    <input type="checkbox" name="times_monday1800"
                        {{ $item->times['monday1800'] ?? false ? 'checked' : '' }} id="times_monday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1800"
                        {{ $item->times['tuesday1800'] ?? false ? 'checked' : '' }} id="times_tuesday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1800"
                        {{ $item->times['wednesday1800'] ?? false ? 'checked' : '' }} id="times_wednesday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1800"
                        {{ $item->times['thursday1800'] ?? false ? 'checked' : '' }} id="times_thursday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1800"
                        {{ $item->times['friday1800'] ?? false ? 'checked' : '' }} id="times_friday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1800"
                        {{ $item->times['saturday1800'] ?? false ? 'checked' : '' }} id="times_saturday1800"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1800"
                        {{ $item->times['sunday1800'] ?? false ? 'checked' : '' }} id="times_sunday1800"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 19:00 до 20:00</td>
                <td>
                    <input type="checkbox" name="times_monday1900"
                        {{ $item->times['monday1900'] ?? false ? 'checked' : '' }} id="times_monday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday1900"
                        {{ $item->times['tuesday1900'] ?? false ? 'checked' : '' }} id="times_tuesday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday1900"
                        {{ $item->times['wednesday1900'] ?? false ? 'checked' : '' }} id="times_wednesday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday1900"
                        {{ $item->times['thursday1900'] ?? false ? 'checked' : '' }} id="times_thursday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday1900"
                        {{ $item->times['friday1900'] ?? false ? 'checked' : '' }} id="times_friday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday1900"
                        {{ $item->times['saturday1900'] ?? false ? 'checked' : '' }} id="times_saturday1900"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday1900"
                        {{ $item->times['sunday1900'] ?? false ? 'checked' : '' }} id="times_sunday1900"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 20:00 до 21:00</td>
                <td>
                    <input type="checkbox" name="times_monday2000"
                        {{ $item->times['monday2000'] ?? false ? 'checked' : '' }} id="times_monday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday2000"
                        {{ $item->times['tuesday2000'] ?? false ? 'checked' : '' }} id="times_tuesday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday2000"
                        {{ $item->times['wednesday2000'] ?? false ? 'checked' : '' }} id="times_wednesday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday2000"
                        {{ $item->times['thursday2000'] ?? false ? 'checked' : '' }} id="times_thursday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday2000"
                        {{ $item->times['friday2000'] ?? false ? 'checked' : '' }} id="times_friday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday2000"
                        {{ $item->times['saturday2000'] ?? false ? 'checked' : '' }} id="times_saturday2000"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday2000"
                        {{ $item->times['sunday2000'] ?? false ? 'checked' : '' }} id="times_sunday2000"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 21:00 до 22:00</td>
                <td>
                    <input type="checkbox" name="times_monday2100"
                        {{ $item->times['monday2100'] ?? false ? 'checked' : '' }} id="times_monday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday2100"
                        {{ $item->times['tuesday2100'] ?? false ? 'checked' : '' }} id="times_tuesday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday2100"
                        {{ $item->times['wednesday2100'] ?? false ? 'checked' : '' }} id="times_wednesday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday2100"
                        {{ $item->times['thursday2100'] ?? false ? 'checked' : '' }} id="times_thursday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday2100"
                        {{ $item->times['friday2100'] ?? false ? 'checked' : '' }} id="times_friday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday2100"
                        {{ $item->times['saturday2100'] ?? false ? 'checked' : '' }} id="times_saturday2100"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday2100"
                        {{ $item->times['sunday2100'] ?? false ? 'checked' : '' }} id="times_sunday2100"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 22:00 до 23:00</td>
                <td>
                    <input type="checkbox" name="times_monday2200"
                        {{ $item->times['monday2200'] ?? false ? 'checked' : '' }} id="times_monday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday2200"
                        {{ $item->times['tuesday2200'] ?? false ? 'checked' : '' }} id="times_tuesday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday2200"
                        {{ $item->times['wednesday2200'] ?? false ? 'checked' : '' }} id="times_wednesday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday2200"
                        {{ $item->times['thursday2200'] ?? false ? 'checked' : '' }} id="times_thursday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday2200"
                        {{ $item->times['friday2200'] ?? false ? 'checked' : '' }} id="times_friday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday2200"
                        {{ $item->times['saturday2200'] ?? false ? 'checked' : '' }} id="times_saturday2200"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday2200"
                        {{ $item->times['sunday2200'] ?? false ? 'checked' : '' }} id="times_sunday2200"
                        label="" />
                </td>
            </tr>
            <tr>
                <td scope="row">с 23:00 до 24:00</td>
                <td>
                    <input type="checkbox" name="times_monday2300"
                        {{ $item->times['monday2300'] ?? false ? 'checked' : '' }} id="times_monday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_tuesday2300"
                        {{ $item->times['tuesday2300'] ?? false ? 'checked' : '' }} id="times_tuesday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_wednesday2300"
                        {{ $item->times['wednesday2300'] ?? false ? 'checked' : '' }} id="times_wednesday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_thursday2300"
                        {{ $item->times['thursday2300'] ?? false ? 'checked' : '' }} id="times_thursday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_friday2300"
                        {{ $item->times['friday2300'] ?? false ? 'checked' : '' }} id="times_friday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_saturday2300"
                        {{ $item->times['saturday2300'] ?? false ? 'checked' : '' }} id="times_saturday2300"
                        label="" />
                </td>
                <td>
                    <input type="checkbox" name="times_sunday2300"
                        {{ $item->times['sunday2300'] ?? false ? 'checked' : '' }} id="times_sunday2300"
                        label="" />
                </td>
            </tr>
        </tbody>
    </table>
@stop

<style type="text/css">
    table.table {
        width: 100% !important;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
        vertical-align: middle;
        padding-top: 5px;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(128, 128, 128, 0.301);
    }

    table.table td .input {
        margin-top: -9px !important;
        padding: 0px;
        margin: 0px;
        display: flex;
        justify-content: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('tr input[type="checkbox"]');

        checkboxes.forEach((e, i) => {
            const field = {
                name: e.name,
                value: e.checked
            }
            window['TWILL'].vm.$store.commit('updateFormField', field);
        });

        let pair = {
            left: null,
            right: null,
        };

        let leftIndex, rightIndex = 0;
        let leftPadding, rightPadding = 0;

        function handleCheck(e) {
            let beetween = false;

            const field = {
                name: e.target.name,
                value: e.target.checked
            }
            window['TWILL'].vm.$store.commit('updateFormField', field);

            if (pair.left == null) {
                pair.left = this;
            }

            if (e.shiftKey && pair.left && pair.left !== e.target) {
                pair.right = this;

                checkboxes.forEach((e, i) => {
                    if (pair.left == e) {
                        leftIndex = i;
                        leftPadding = i % 7;
                    }
                    if (pair.right == e) {
                        rightIndex = i;
                        rightPadding = i % 7;
                    }
                });


                checkboxes.forEach((e, i) => {
                    beetween = ((i >= leftIndex && i <= rightIndex) ||
                        (i <= leftIndex && i >= rightIndex));

                    beetween &= i % 7 <= leftPadding || i % 7 <= rightPadding;
                    beetween &= i % 7 >= leftPadding || i % 7 >= rightPadding;

                    if (
                        beetween
                    ) {
                        e.checked = pair.left.checked;

                        const field = {
                            name: e.name,
                            value: e.checked
                        }
                        window['TWILL'].vm.$store.commit('updateFormField', field);
                    }
                })

                pair.left = null;
                pair.right = null;
                leftIndex, rightIndex = 0;
            }
        };

        checkboxes.forEach(checkbox => checkbox.addEventListener('click', handleCheck));
    })
</script>
