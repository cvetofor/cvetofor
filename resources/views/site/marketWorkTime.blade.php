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
                <input type="checkbox" {{ optional($item->times)['monday0000'] ? 'checked' : '' }} disabled
                    name="times_monday0000" id="times_monday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0000'] ? 'checked' : '' }} disabled
                    name="times_tuesday0000" id="times_tuesday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0000'] ? 'checked' : '' }} disabled
                    name="times_wednesday0000" id="times_wednesday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0000'] ? 'checked' : '' }} disabled
                    name="times_thursday0000" id="times_thursday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0000'] ? 'checked' : '' }} disabled
                    name="times_friday0000" id="times_friday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0000'] ? 'checked' : '' }} disabled
                    name="times_saturday0000" id="times_saturday0000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0000'] ? 'checked' : '' }} disabled
                    name="times_sunday0000" id="times_sunday0000" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 01:00 до 02:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0100'] ? 'checked' : '' }} disabled
                    name="times_monday0100" id="times_monday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0100'] ? 'checked' : '' }} disabled
                    name="times_tuesday0100" id="times_tuesday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0100'] ? 'checked' : '' }} disabled
                    name="times_wednesday0100" id="times_wednesday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0100'] ? 'checked' : '' }} disabled
                    name="times_thursday0100" id="times_thursday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0100'] ? 'checked' : '' }} disabled
                    name="times_friday0100" id="times_friday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0100'] ? 'checked' : '' }} disabled
                    name="times_saturday0100" id="times_saturday0100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0100'] ? 'checked' : '' }} disabled
                    name="times_sunday0100" id="times_sunday0100" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 02:00 до 03:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0200'] ? 'checked' : '' }} disabled
                    name="times_monday0200" id="times_monday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0200'] ? 'checked' : '' }} disabled
                    name="times_tuesday0200" id="times_tuesday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0200'] ? 'checked' : '' }} disabled
                    name="times_wednesday0200" id="times_wednesday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0200'] ? 'checked' : '' }} disabled
                    name="times_thursday0200" id="times_thursday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0200'] ? 'checked' : '' }} disabled
                    name="times_friday0200" id="times_friday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0200'] ? 'checked' : '' }} disabled
                    name="times_saturday0200" id="times_saturday0200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0200'] ? 'checked' : '' }} disabled
                    name="times_sunday0200" id="times_sunday0200" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 03:00 до 04:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0300'] ? 'checked' : '' }} disabled
                    name="times_monday0300" id="times_monday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0300'] ? 'checked' : '' }} disabled
                    name="times_tuesday0300" id="times_tuesday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0300'] ? 'checked' : '' }} disabled
                    name="times_wednesday0300" id="times_wednesday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0300'] ? 'checked' : '' }} disabled
                    name="times_thursday0300" id="times_thursday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0300'] ? 'checked' : '' }} disabled
                    name="times_friday0300" id="times_friday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0300'] ? 'checked' : '' }} disabled
                    name="times_saturday0300" id="times_saturday0300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0300'] ? 'checked' : '' }} disabled
                    name="times_sunday0300" id="times_sunday0300" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 04:00 до 05:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0400'] ? 'checked' : '' }} disabled
                    name="times_monday0400" id="times_monday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0400'] ? 'checked' : '' }} disabled
                    name="times_tuesday0400" id="times_tuesday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0400'] ? 'checked' : '' }} disabled
                    name="times_wednesday0400" id="times_wednesday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0400'] ? 'checked' : '' }} disabled
                    name="times_thursday0400" id="times_thursday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0400'] ? 'checked' : '' }} disabled
                    name="times_friday0400" id="times_friday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0400'] ? 'checked' : '' }} disabled
                    name="times_saturday0400" id="times_saturday0400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0400'] ? 'checked' : '' }} disabled
                    name="times_sunday0400" id="times_sunday0400" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 05:00 до 06:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0500'] ? 'checked' : '' }} disabled
                    name="times_monday0500" id="times_monday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0500'] ? 'checked' : '' }} disabled
                    name="times_tuesday0500" id="times_tuesday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0500'] ? 'checked' : '' }} disabled
                    name="times_wednesday0500" id="times_wednesday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0500'] ? 'checked' : '' }} disabled
                    name="times_thursday0500" id="times_thursday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0500'] ? 'checked' : '' }} disabled
                    name="times_friday0500" id="times_friday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0500'] ? 'checked' : '' }} disabled
                    name="times_saturday0500" id="times_saturday0500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0500'] ? 'checked' : '' }} disabled
                    name="times_sunday0500" id="times_sunday0500" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 06:00 до 07:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0600'] ? 'checked' : '' }} disabled
                    name="times_monday0600" id="times_monday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0600'] ? 'checked' : '' }} disabled
                    name="times_tuesday0600" id="times_tuesday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0600'] ? 'checked' : '' }} disabled
                    name="times_wednesday0600" id="times_wednesday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0600'] ? 'checked' : '' }} disabled
                    name="times_thursday0600" id="times_thursday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0600'] ? 'checked' : '' }} disabled
                    name="times_friday0600" id="times_friday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0600'] ? 'checked' : '' }} disabled
                    name="times_saturday0600" id="times_saturday0600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0600'] ? 'checked' : '' }} disabled
                    name="times_sunday0600" id="times_sunday0600" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 07:00 до 08:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0700'] ? 'checked' : '' }} disabled
                    name="times_monday0700" id="times_monday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0700'] ? 'checked' : '' }} disabled
                    name="times_tuesday0700" id="times_tuesday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0700'] ? 'checked' : '' }} disabled
                    name="times_wednesday0700" id="times_wednesday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0700'] ? 'checked' : '' }} disabled
                    name="times_thursday0700" id="times_thursday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0700'] ? 'checked' : '' }} disabled
                    name="times_friday0700" id="times_friday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0700'] ? 'checked' : '' }} disabled
                    name="times_saturday0700" id="times_saturday0700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0700'] ? 'checked' : '' }} disabled
                    name="times_sunday0700" id="times_sunday0700" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 08:00 до 09:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0800'] ? 'checked' : '' }} disabled
                    name="times_monday0800" id="times_monday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0800'] ? 'checked' : '' }} disabled
                    name="times_tuesday0800" id="times_tuesday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0800'] ? 'checked' : '' }} disabled
                    name="times_wednesday0800" id="times_wednesday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0800'] ? 'checked' : '' }} disabled
                    name="times_thursday0800" id="times_thursday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0800'] ? 'checked' : '' }} disabled
                    name="times_friday0800" id="times_friday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0800'] ? 'checked' : '' }} disabled
                    name="times_saturday0800" id="times_saturday0800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0800'] ? 'checked' : '' }} disabled
                    name="times_sunday0800" id="times_sunday0800" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 09:00 до 10:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday0900'] ? 'checked' : '' }} disabled
                    name="times_monday0900" id="times_monday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday0900'] ? 'checked' : '' }} disabled
                    name="times_tuesday0900" id="times_tuesday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday0900'] ? 'checked' : '' }} disabled
                    name="times_wednesday0900" id="times_wednesday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday0900'] ? 'checked' : '' }} disabled
                    name="times_thursday0900" id="times_thursday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday0900'] ? 'checked' : '' }} disabled
                    name="times_friday0900" id="times_friday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday0900'] ? 'checked' : '' }} disabled
                    name="times_saturday0900" id="times_saturday0900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday0900'] ? 'checked' : '' }} disabled
                    name="times_sunday0900" id="times_sunday0900" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 10:00 до 11:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1000'] ? 'checked' : '' }} disabled
                    name="times_monday1000" id="times_monday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1000'] ? 'checked' : '' }} disabled
                    name="times_tuesday1000" id="times_tuesday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1000'] ? 'checked' : '' }} disabled
                    name="times_wednesday1000" id="times_wednesday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1000'] ? 'checked' : '' }} disabled
                    name="times_thursday1000" id="times_thursday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1000'] ? 'checked' : '' }} disabled
                    name="times_friday1000" id="times_friday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1000'] ? 'checked' : '' }} disabled
                    name="times_saturday1000" id="times_saturday1000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1000'] ? 'checked' : '' }} disabled
                    name="times_sunday1000" id="times_sunday1000" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 11:00 до 12:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1100'] ? 'checked' : '' }} disabled
                    name="times_monday1100" id="times_monday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1100'] ? 'checked' : '' }} disabled
                    name="times_tuesday1100" id="times_tuesday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1100'] ? 'checked' : '' }} disabled
                    name="times_wednesday1100" id="times_wednesday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1100'] ? 'checked' : '' }} disabled
                    name="times_thursday1100" id="times_thursday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1100'] ? 'checked' : '' }} disabled
                    name="times_friday1100" id="times_friday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1100'] ? 'checked' : '' }} disabled
                    name="times_saturday1100" id="times_saturday1100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1100'] ? 'checked' : '' }} disabled
                    name="times_sunday1100" id="times_sunday1100" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 12:00 до 13:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1200'] ? 'checked' : '' }} disabled
                    name="times_monday1200" id="times_monday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1200'] ? 'checked' : '' }} disabled
                    name="times_tuesday1200" id="times_tuesday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1200'] ? 'checked' : '' }} disabled
                    name="times_wednesday1200" id="times_wednesday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1200'] ? 'checked' : '' }} disabled
                    name="times_thursday1200" id="times_thursday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1200'] ? 'checked' : '' }} disabled
                    name="times_friday1200" id="times_friday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1200'] ? 'checked' : '' }} disabled
                    name="times_saturday1200" id="times_saturday1200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1200'] ? 'checked' : '' }} disabled
                    name="times_sunday1200" id="times_sunday1200" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 13:00 до 14:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1300'] ? 'checked' : '' }} disabled
                    name="times_monday1300" id="times_monday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1300'] ? 'checked' : '' }} disabled
                    name="times_tuesday1300" id="times_tuesday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1300'] ? 'checked' : '' }} disabled
                    name="times_wednesday1300" id="times_wednesday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1300'] ? 'checked' : '' }} disabled
                    name="times_thursday1300" id="times_thursday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1300'] ? 'checked' : '' }} disabled
                    name="times_friday1300" id="times_friday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1300'] ? 'checked' : '' }} disabled
                    name="times_saturday1300" id="times_saturday1300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1300'] ? 'checked' : '' }} disabled
                    name="times_sunday1300" id="times_sunday1300" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 14:00 до 15:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1400'] ? 'checked' : '' }} disabled
                    name="times_monday1400" id="times_monday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1400'] ? 'checked' : '' }} disabled
                    name="times_tuesday1400" id="times_tuesday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1400'] ? 'checked' : '' }} disabled
                    name="times_wednesday1400" id="times_wednesday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1400'] ? 'checked' : '' }} disabled
                    name="times_thursday1400" id="times_thursday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1400'] ? 'checked' : '' }} disabled
                    name="times_friday1400" id="times_friday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1400'] ? 'checked' : '' }} disabled
                    name="times_saturday1400" id="times_saturday1400" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1400'] ? 'checked' : '' }} disabled
                    name="times_sunday1400" id="times_sunday1400" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 15:00 до 16:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1500'] ? 'checked' : '' }} disabled
                    name="times_monday1500" id="times_monday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1500'] ? 'checked' : '' }} disabled
                    name="times_tuesday1500" id="times_tuesday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1500'] ? 'checked' : '' }} disabled
                    name="times_wednesday1500" id="times_wednesday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1500'] ? 'checked' : '' }} disabled
                    name="times_thursday1500" id="times_thursday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1500'] ? 'checked' : '' }} disabled
                    name="times_friday1500" id="times_friday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1500'] ? 'checked' : '' }} disabled
                    name="times_saturday1500" id="times_saturday1500" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1500'] ? 'checked' : '' }} disabled
                    name="times_sunday1500" id="times_sunday1500" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 16:00 до 17:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1600'] ? 'checked' : '' }} disabled
                    name="times_monday1600" id="times_monday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1600'] ? 'checked' : '' }} disabled
                    name="times_tuesday1600" id="times_tuesday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1600'] ? 'checked' : '' }} disabled
                    name="times_wednesday1600" id="times_wednesday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1600'] ? 'checked' : '' }} disabled
                    name="times_thursday1600" id="times_thursday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1600'] ? 'checked' : '' }} disabled
                    name="times_friday1600" id="times_friday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1600'] ? 'checked' : '' }} disabled
                    name="times_saturday1600" id="times_saturday1600" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1600'] ? 'checked' : '' }} disabled
                    name="times_sunday1600" id="times_sunday1600" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 17:00 до 18:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1700'] ? 'checked' : '' }} disabled
                    name="times_monday1700" id="times_monday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1700'] ? 'checked' : '' }} disabled
                    name="times_tuesday1700" id="times_tuesday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1700'] ? 'checked' : '' }} disabled
                    name="times_wednesday1700" id="times_wednesday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1700'] ? 'checked' : '' }} disabled
                    name="times_thursday1700" id="times_thursday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1700'] ? 'checked' : '' }} disabled
                    name="times_friday1700" id="times_friday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1700'] ? 'checked' : '' }} disabled
                    name="times_saturday1700" id="times_saturday1700" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1700'] ? 'checked' : '' }} disabled
                    name="times_sunday1700" id="times_sunday1700" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 18:00 до 19:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1800'] ? 'checked' : '' }} disabled
                    name="times_monday1800" id="times_monday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1800'] ? 'checked' : '' }} disabled
                    name="times_tuesday1800" id="times_tuesday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1800'] ? 'checked' : '' }} disabled
                    name="times_wednesday1800" id="times_wednesday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1800'] ? 'checked' : '' }} disabled
                    name="times_thursday1800" id="times_thursday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1800'] ? 'checked' : '' }} disabled
                    name="times_friday1800" id="times_friday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1800'] ? 'checked' : '' }} disabled
                    name="times_saturday1800" id="times_saturday1800" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1800'] ? 'checked' : '' }} disabled
                    name="times_sunday1800" id="times_sunday1800" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 19:00 до 20:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday1900'] ? 'checked' : '' }} disabled
                    name="times_monday1900" id="times_monday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday1900'] ? 'checked' : '' }} disabled
                    name="times_tuesday1900" id="times_tuesday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday1900'] ? 'checked' : '' }} disabled
                    name="times_wednesday1900" id="times_wednesday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday1900'] ? 'checked' : '' }} disabled
                    name="times_thursday1900" id="times_thursday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday1900'] ? 'checked' : '' }} disabled
                    name="times_friday1900" id="times_friday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday1900'] ? 'checked' : '' }} disabled
                    name="times_saturday1900" id="times_saturday1900" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday1900'] ? 'checked' : '' }} disabled
                    name="times_sunday1900" id="times_sunday1900" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 20:00 до 21:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday2000'] ? 'checked' : '' }} disabled
                    name="times_monday2000" id="times_monday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday2000'] ? 'checked' : '' }} disabled
                    name="times_tuesday2000" id="times_tuesday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday2000'] ? 'checked' : '' }} disabled
                    name="times_wednesday2000" id="times_wednesday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday2000'] ? 'checked' : '' }} disabled
                    name="times_thursday2000" id="times_thursday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday2000'] ? 'checked' : '' }} disabled
                    name="times_friday2000" id="times_friday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday2000'] ? 'checked' : '' }} disabled
                    name="times_saturday2000" id="times_saturday2000" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday2000'] ? 'checked' : '' }} disabled
                    name="times_sunday2000" id="times_sunday2000" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 21:00 до 22:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday2100'] ? 'checked' : '' }} disabled
                    name="times_monday2100" id="times_monday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday2100'] ? 'checked' : '' }} disabled
                    name="times_tuesday2100" id="times_tuesday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday2100'] ? 'checked' : '' }} disabled
                    name="times_wednesday2100" id="times_wednesday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday2100'] ? 'checked' : '' }} disabled
                    name="times_thursday2100" id="times_thursday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday2100'] ? 'checked' : '' }} disabled
                    name="times_friday2100" id="times_friday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday2100'] ? 'checked' : '' }} disabled
                    name="times_saturday2100" id="times_saturday2100" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday2100'] ? 'checked' : '' }} disabled
                    name="times_sunday2100" id="times_sunday2100" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 22:00 до 23:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday2200'] ? 'checked' : '' }} disabled
                    name="times_monday2200" id="times_monday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday2200'] ? 'checked' : '' }} disabled
                    name="times_tuesday2200" id="times_tuesday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday2200'] ? 'checked' : '' }} disabled
                    name="times_wednesday2200" id="times_wednesday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday2200'] ? 'checked' : '' }} disabled
                    name="times_thursday2200" id="times_thursday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday2200'] ? 'checked' : '' }} disabled
                    name="times_friday2200" id="times_friday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday2200'] ? 'checked' : '' }} disabled
                    name="times_saturday2200" id="times_saturday2200" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday2200'] ? 'checked' : '' }} disabled
                    name="times_sunday2200" id="times_sunday2200" label="" />
            </td>
        </tr>
        <tr>
            <td scope="row">с 23:00 до 24:00</td>
            <td>
                <input type="checkbox" {{ optional($item->times)['monday2300'] ? 'checked' : '' }} disabled
                    name="times_monday2300" id="times_monday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['tuesday2300'] ? 'checked' : '' }} disabled
                    name="times_tuesday2300" id="times_tuesday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['wednesday2300'] ? 'checked' : '' }} disabled
                    name="times_wednesday2300" id="times_wednesday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['thursday2300'] ? 'checked' : '' }} disabled
                    name="times_thursday2300" id="times_thursday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['friday2300'] ? 'checked' : '' }} disabled
                    name="times_friday2300" id="times_friday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['saturday2300'] ? 'checked' : '' }} disabled
                    name="times_saturday2300" id="times_saturday2300" label="" />
            </td>
            <td>
                <input type="checkbox" {{ optional($item->times)['sunday2300'] ? 'checked' : '' }} disabled
                    name="times_sunday2300" id="times_sunday2300" label="" />
            </td>
        </tr>
    </tbody>
</table>

<style type="text/css">
    table.table {
        width: 100% !important;
    }

    .table td {
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
