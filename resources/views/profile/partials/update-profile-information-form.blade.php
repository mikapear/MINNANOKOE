<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            プロフィール情報
        </h2>

        @if (session('status') === 'profile-updated')
            <span class="text-sm font-medium text-green-600">
                ✓ 保存しました
            </span>
        @endif

        <p class="mt-1 text-sm text-gray-600">
            ニックネーム・連絡先・プロフィール情報を更新できます。
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="ニックネーム" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="nickname" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        メールアドレスの認証が完了していません。

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            認証メールを再送する
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            認証メールを送信しました。
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label value="生年月" />

            @php
                $birthYear = old('birth_year', optional($user->birth_date)->format('Y'));
                $birthMonth = old('birth_month', optional($user->birth_date)->format('n'));
            @endphp

            <div class="mt-1 flex gap-2">

                <select name="birth_year"
                    class="block w-1/2 border-gray-300 rounded-md shadow-sm">

                    <option value="">年</option>

                    @for ($year = date('Y'); $year >= 1920; $year--)
                        <option value="{{ $year }}"
                            {{ $birthYear == $year ? 'selected' : '' }}>
                            {{ $year }}年
                        </option>
                    @endfor

                </select>

                <select name="birth_month"
                    class="block w-1/2 border-gray-300 rounded-md shadow-sm">

                    <option value="">月</option>

                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}"
                            {{ $birthMonth == $month ? 'selected' : '' }}>
                            {{ $month }}月
                        </option>
                    @endfor

                </select>

            </div>

            <x-input-error class="mt-2" :messages="$errors->get('birth_year')" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_month')" />
        </div>

        <div>
            <x-input-label value="あなたの立場（複数選択可）" />

            @php
                $selectedRoles = collect(old('roles', $user->roles ?? []));
            @endphp

            <div class="mt-2 space-y-2">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox"
                        id="role_patient"
                        name="roles[]"
                        value="patient"
                        @checked($selectedRoles->contains('patient'))>
                    <span>患者</span>
                </label>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox"
                        name="roles[]"
                        value="family"
                        @checked($selectedRoles->contains('family'))>
                    <span>家族</span>
                </label>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox"
                        name="roles[]"
                        value="friend"
                        @checked($selectedRoles->contains('friend'))>
                    <span>友人・職場</span>
                </label>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox"
                        name="roles[]"
                        value="medical"
                        @checked($selectedRoles->contains('medical'))>
                    <span>医療者</span>
                </label>
            </div>
        </div>
    <div id="patient-fields" class="space-y-4">
        <div>
            <x-input-label value="診断年月" />

            @php
                $diagnosedYear = old('diagnosed_year', optional($user->diagnosed_at)->format('Y'));
                $diagnosedMonth = old('diagnosed_month', optional($user->diagnosed_at)->format('n'));
            @endphp

            <div class="mt-1 flex gap-2">

                <select name="diagnosed_year"
                    class="block w-1/2 border-gray-300 rounded-md shadow-sm">

                    <option value="">年</option>

                    @for ($year = date('Y'); $year >= 1980; $year--)
                        <option value="{{ $year }}"
                            {{ $diagnosedYear == $year ? 'selected' : '' }}>
                            {{ $year }}年
                        </option>
                    @endfor

                </select>

                <select name="diagnosed_month"
                    class="block w-1/2 border-gray-300 rounded-md shadow-sm">

                    <option value="">月</option>

                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}"
                            {{ $diagnosedMonth == $month ? 'selected' : '' }}>
                            {{ $month }}月
                        </option>
                    @endfor

                </select>

            </div>

            <x-input-error class="mt-2" :messages="$errors->get('diagnosed_year')" />
            <x-input-error class="mt-2" :messages="$errors->get('diagnosed_month')" />
        </div>

        <div>
            <x-input-label for="treatment_status" value="現在の治療状況" />

            <select
                name="treatment_status"
                id="treatment_status"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
            >
                <option value="">選択してください</option>

                <option value="under_treatment"
                    @selected(old('treatment_status', $user->treatment_status) === 'under_treatment')>
                    治療中
                </option>

                <option value="completed"
                    @selected(old('treatment_status', $user->treatment_status) === 'completed')>
                    治療終了
                </option>

                <option value="recurrence"
                    @selected(old('treatment_status', $user->treatment_status) === 'recurrence')>
                    再発治療中
                </option>

                <option value="metastatic"
                    @selected(old('treatment_status', $user->treatment_status) === 'metastatic')>
                    転移治療中
                </option>
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('treatment_status')" />
        </div>

        <fieldset class="space-y-4">
            <legend class="text-sm font-medium text-gray-700">
                治療内容（複数選択可）
        </legend>

            @php
                $selectedTreatments = collect(
                    old('treatment_types', $user->treatment_types ?? [])
                );
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
        </fieldset>
    </div>
        <div class="flex items-center gap-4">
            <x-primary-button>保存</x-primary-button>

        </div>
    <script>
    function togglePatientFields() {
        const patientCheckbox = document.getElementById('role_patient');
        const patientFields = document.getElementById('patient-fields');

        if (!patientCheckbox || !patientFields) return;

        patientFields.style.display = patientCheckbox.checked ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const patientCheckbox = document.getElementById('role_patient');

        if (patientCheckbox) {
            patientCheckbox.addEventListener('change', togglePatientFields);
            togglePatientFields();
        }
    });
    </script>
    </form>
</section>
