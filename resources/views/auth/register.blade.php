<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="ニックネーム（表示名）" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="nickname" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="パスワード" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="パスワード（確認）" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
    <x-input-label for="birth_year" value="生年月" />

    <div class="flex gap-2 mt-1">
        <select name="birth_year" id="birth_year" required
            class="block w-1/2 border-gray-300 rounded-md shadow-sm">
            <option value="">年</option>
            @for ($year = date('Y'); $year >= 1920; $year--)
                <option value="{{ $year }}" {{ old('birth_year') == $year ? 'selected' : '' }}>
                    {{ $year }}年
                </option>
            @endfor
        </select>

        <select name="birth_month" id="birth_month" required
            class="block w-1/2 border-gray-300 rounded-md shadow-sm">
            <option value="">月</option>
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}" {{ old('birth_month') == $month ? 'selected' : '' }}>
                    {{ $month }}月
                </option>
            @endfor
        </select>
    </div>

        <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
        <x-input-error :messages="$errors->get('birth_month')" class="mt-2" />
    </div>

        <div>
    <x-input-label for="diagnosed_year" value="診断年月" />

    <div class="flex gap-2 mt-1">
        <select name="diagnosed_year" id="diagnosed_year" required
            class="block w-1/2 border-gray-300 rounded-md shadow-sm">

            <option value="">年</option>

            @for ($year = date('Y'); $year >= 1980; $year--)
                <option value="{{ $year }}"
                    {{ old('diagnosed_year') == $year ? 'selected' : '' }}>
                    {{ $year }}年
                </option>
            @endfor
        </select>

        <select name="diagnosed_month" id="diagnosed_month" required
            class="block w-1/2 border-gray-300 rounded-md shadow-sm">

            <option value="">月</option>

            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}"
                    {{ old('diagnosed_month') == $month ? 'selected' : '' }}>
                    {{ $month }}月
                </option>
            @endfor
        </select>
    </div>

        <x-input-error :messages="$errors->get('diagnosed_year')" class="mt-2" />
        <x-input-error :messages="$errors->get('diagnosed_month')" class="mt-2" />
    </div>

        <fieldset class="space-y-4">
            <legend class="text-sm font-medium text-gray-700">
                治療内容（複数選択可）
        </legend>

            @php
                $selectedTreatments = collect(old('treatment_types', []));
            @endphp

            <div class="rounded-lg border border-gray-200 p-4">
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="treatment_types[]" value="surgery"
                        @checked($selectedTreatments->contains('surgery'))>
                    <span>手術</span>
                </label>

                <div class="mt-2 ml-6 space-y-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="surgery_partial"
                            @checked($selectedTreatments->contains('surgery_partial'))>
                        <span>乳房部分切除術</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="surgery_mastectomy"
                            @checked($selectedTreatments->contains('surgery_mastectomy'))>
                        <span>乳房全摘術</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="slnb"
                            @checked($selectedTreatments->contains('slnb'))>
                        <span>センチネルリンパ節生検</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="alnd"
                         @checked($selectedTreatments->contains('alnd'))>
                        <span>腋窩郭清</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="recon"
                         @checked($selectedTreatments->contains('recon'))>
                        <span>乳房再建術</span>
                    </label>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 p-4">
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="treatment_types[]" value="chemotherapy"
                        @checked($selectedTreatments->contains('chemotherapy'))>
                    <span>化学療法</span>
                </label>

                <div class="mt-2 ml-6 space-y-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="chemo_neoadjuvant"
                            @checked($selectedTreatments->contains('chemo_neoadjuvant'))>
                        <span>術前化学療法</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="chemo_adjuvant"
                            @checked($selectedTreatments->contains('chemo_adjuvant'))>
                        <span>術後化学療法</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="chemo_ac/ec"
                            @checked($selectedTreatments->contains('chemo_ac/ec'))>
                        <span>AC/EC療法</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="chemo_tc"
                            @checked($selectedTreatments->contains('chemo_tc'))>
                        <span>TC療法</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="chemo_taxan"
                            @checked($selectedTreatments->contains('chemo_taxan'))>
                        <span>タキサン系抗がん剤</span>
                    </label>
                </div>
            </div>

        <div class="rounded-lg border border-gray-200 p-4">
    
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="treatment_types[]" value="targeted"
                    @checked($selectedTreatments->contains('targeted'))>
                <span>分子標的薬</span>
            </label>

            <div class="mt-2 ml-6 space-y-1">

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="treatment_types[]" value="trastuzumab/pertuzumab"
                        @checked($selectedTreatments->contains('trastuzumab/pertuzumab'))>
                    <span>トラスツズマブ/ペルスツマブ</span>
                </label>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="treatment_types[]" value="CDK4/6"
                        @checked($selectedTreatments->contains('CDK4/6'))>
                    <span>CDK4/6阻害薬</span>
                </label>
            </div>
        </div>
    
        <div class="rounded-lg border border-gray-200 p-4">

        <label class="flex items-center gap-2 text-sm font-semibold">
            <input type="checkbox" name="treatment_types[]" value="immunotherapy"
                @checked($selectedTreatments->contains('immunotherapy'))>
            <span>免疫チェックポイント阻害薬</span>
        </label>
        </div>

            <div class="rounded-lg border border-gray-200 p-4">
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="treatment_types[]" value="hormone"
                        @checked($selectedTreatments->contains('hormone'))>
                    <span>ホルモン治療</span>
                </label>

                <div class="mt-2 ml-6 space-y-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="hormone_tamoxifen"
                            @checked($selectedTreatments->contains('hormone_tamoxifen'))>
                        <span>タモキシフェン</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="hormone_ai"
                            @checked($selectedTreatments->contains('hormone_ai'))>
                        <span>アロマターゼ阻害薬</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="treatment_types[]" value="hormone_lhrh"
                            @checked($selectedTreatments->contains('hormone_lhrh'))>
                        <span>LH-RHアゴニスト</span>
                    </label>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 p-4">
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="treatment_types[]" value="radiation"
                        @checked($selectedTreatments->contains('radiation'))>
                    <span>放射線治療</span>
                </label>
            </div>

            <x-input-error :messages="$errors->get('treatment_types')" class="mt-2" />
        </fieldset>

        <label class="flex items-start gap-2 text-sm">
            <input type="checkbox" name="privacy" value="1" class="mt-1 rounded border-gray-300" @checked(old('privacy')) required />
            <span>
                <a href="{{ route('terms') }}" target="_blank" class="text-indigo-600 underline">利用規約</a>
                および
                <a href="{{ route('privacy') }}" target="_blank" class="text-indigo-600 underline">プライバシーポリシー</a>
                に同意します。
            </span>
        </label>
        <x-input-error :messages="$errors->get('privacy')" class="mt-2" />

        <div class="flex items-center justify-end gap-4 pt-2">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">ログインへ</a>
            <x-primary-button>登録する</x-primary-button>
        </div>
    </form>
</x-guest-layout>
