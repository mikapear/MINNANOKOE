@extends('layouts.site')

@section('title', '利用規約 | '.config('app.name'))

@section('content')
<div class="mx-auto max-w-4xl">

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-indigo-900">利用規約</h1>
        <p class="mt-3 text-sm text-gray-500">
            みんなの声辞典をご利用いただくにあたり、以下の利用規約をご確認ください。
        </p>
        <p class="mt-2 text-xs text-gray-400">
            制定日：2026年6月3日
        </p>
    </div>

    <article class="space-y-6">

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第1条　本サービスについて</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>「みんなの声辞典」（以下「本サービス」といいます。）は、乳がんを経験した方が、自身の経験や感じたことを共有し、その声を残すためのサービスです。</p>
                <p>治療中に感じた不安や悩み、助けられた言葉、日々の工夫や生活の変化など、一人ひとりの体験には大切な意味があります。</p>
                <p>本サービスは、その時の気持ちや経験を記録し、同じような経験をする方やそのご家族の支えとなることを目的としています。</p>
                <p>本サービスは、利用者同士の体験共有を目的としたものであり、医療上の診断、治療、助言その他の医療行為を提供するものではありません。</p>
                <p>利用者は、本利用規約に同意したうえで本サービスを利用するものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第2条　アカウント登録</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>本サービスの利用にあたり、利用者は運営者の定める方法によりアカウント登録を行うものとします。</p>
                <p>利用者は、登録情報について正確かつ最新の内容を登録するものとします。</p>
                <p>利用者は、自己の責任においてアカウント情報を管理するものとし、第三者に譲渡、貸与または共有してはなりません。</p>
                <p>運営者は、利用者が本利用規約に違反した場合、その他本サービスの運営上不適切と判断した場合には、事前の通知なくアカウントの利用停止または削除を行うことがあります。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第3条　投稿について</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>利用者は、本サービスに自身の経験、考え、感想その他の内容を投稿することができます。</p>
                <p>利用者は、投稿内容について必要な権利を有していること、または正当な権限に基づいて投稿していることを保証するものとします。</p>
                <p>利用者は、投稿内容について自ら責任を負うものとし、第三者との間で紛争が生じた場合には、自らの責任と費用において解決するものとします。</p>
                <p>本サービスへの投稿は、原則として匿名で公開されます。ただし、利用者が投稿内容に個人を特定できる情報を記載した場合、その情報が公開される可能性があります。</p>
                <p>利用者は、投稿にあたり、自身および第三者の個人情報の保護に十分配慮するものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第4条　投稿内容の編集・掲載見送り</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>本サービスに投稿された内容は、公開前に運営者が確認を行います。</p>
                <p>運営者は、利用者および第三者の個人情報保護、本サービスの趣旨との整合性、読みやすさの向上その他運営上必要と判断した場合、投稿内容について修正をお願いすることがあります。また、個人情報の削除、表記の調整、タグ付け、分類その他の整理を行うことがあります。
                </p>
                <p>運営者は、投稿内容が本利用規約に違反すると判断した場合、本サービスの趣旨に適さないと判断した場合、またはその他運営上の理由により、投稿を公開しないことがあります。</p>
                <p>運営者は、公開後の投稿についても、必要に応じて非公開化、修正または削除を行うことがあります。</p>
                <p>運営者は、投稿の編集、掲載見送り、非公開化または削除の理由について説明する義務を負わないものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第5条　禁止事項</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>利用者は、本サービスの利用にあたり、以下の行為を行ってはなりません。</p>
                <ol class="list-decimal space-y-2 pl-6">
                    <li>本サービスの趣旨に反する内容を投稿する行為</li>
                    <li>他の利用者または第三者を誹謗中傷し、名誉または信用を傷つける行為</li>
                    <li>本人の同意なく個人情報、連絡先、住所その他個人を特定できる情報を掲載する行為</li>
                    <li>他の利用者または第三者の個人情報を本人の同意なく掲載する行為</li>
                    <li>虚偽の情報を投稿する行為</li>
                    <li>医療機関、医療従事者、患者その他の個人または団体に対する攻撃、嫌がらせまたは差別的な表現を含む行為</li>
                    <li>医薬品、健康食品、サプリメントその他の商品またはサービスの販売、宣伝または勧誘を行う行為</li>
                    <li>科学的根拠に乏しい医療情報、危険な治療法または健康被害を生じるおそれのある情報を推奨または拡散する行為</li>
                    <li>商品、サービス、ネットワークビジネスその他の営利目的による宣伝、勧誘または広告行為</li>
                    <li>他人になりすまして本サービスを利用する行為</li>
                    <li>本サービスの運営を妨害する行為</li>
                    <li>法令または公序良俗に違反する行為</li>
                    <li>その他、運営者が不適切と判断する行為</li>
                </ol>
            </div>
            <p class="mt-4">
                利用者が前項各号のいずれかに違反した場合、運営者は、投稿の非公開化、削除、アカウントの停止その他必要な措置を講じることができます。
            </p>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第6条　知的財産権</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>本サービスに掲載されるロゴ、イラスト、キャラクター、デザイン、文章、画像、プログラムその他のコンテンツ（利用者が投稿した内容を除きます。）に関する著作権その他の知的財産権は、運営者または正当な権利者に帰属します。</p>
                <p>本サービスに関連して使用されるプログラム、ロゴ、イラスト、キャラクター、デザインその他のコンテンツは、知的財産権に関する法令等により保護されています。</p>
                <p>利用者は、法令で認められる場合を除き、運営者または権利者の許可なく、これらのコンテンツを複製、転載、改変、配布その他の方法で利用してはなりません。</p>
                <p>利用者が本サービスに投稿した文章その他のコンテンツに関する著作権その他の知的財産権は、当該利用者または正当な権利者に帰属します。</p>
                <p>運営者は、利用者の個人情報保護および本サービスの趣旨に沿った運営のため、投稿内容の一部を編集または要約して利用することがあります。</p>
                <p>利用者は、投稿内容について第三者の権利を侵害しないことを保証するものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第7条　個人情報の取り扱い</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>運営者は、利用者の個人情報を、法令および別途定めるプライバシーポリシーに従って適切に取り扱います。</p>
                <p>運営者は、本サービスの提供、本人確認、お問い合わせ対応、本サービスの改善その他運営上必要な目的のために、利用者の個人情報を利用することがあります。</p>
                <p>利用者が登録した情報および投稿内容については、個人情報保護に十分配慮して管理します。</p>
                <p>個人情報の収集、利用、管理その他の取り扱いについては、別途定めるプライバシーポリシーによるものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第8条　免責事項</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>本サービスに掲載される投稿、コメントその他の情報は、利用者個人の経験、意見および感想を含むものであり、その正確性、有用性、完全性または最新性を運営者が保証するものではありません。</p>
                <p>本サービスは、利用者同士の体験共有を目的としたものであり、医療上の診断、治療、助言その他の医療行為を提供するものではありません。利用者は、健康や治療に関する判断を行う際には、医師その他の医療専門職へ相談するものとします。</p>
                <p>利用者は、自らの責任において本サービスを利用するものとし、本サービスの利用または利用できなかったことにより生じた損害について、運営者は故意または重大な過失がある場合を除き責任を負いません。</p>
                <p>利用者間または利用者と第三者との間で生じた紛争について、運営者は責任を負わないものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第9条　サービス変更・停止</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>運営者は、利用者への事前の通知なく、本サービスの内容を変更し、または提供を中断もしくは終了することがあります。</p>
                <p>運営者は、システム保守、障害対応、災害その他やむを得ない事由により、本サービスの全部または一部を停止することがあります。</p>
                <p>運営者は、本条に基づくサービス内容の変更、中断または終了により利用者に生じた損害について、故意または重大な過失がある場合を除き責任を負わないものとします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第10条　規約変更</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>運営者は、必要と判断した場合には、利用者への事前通知その他適切な方法により、本利用規約を変更することができます。</p>
                <p>変更後の利用規約は、本サービス上に掲載された時点または運営者が別途定める時点から効力を生じるものとします。</p>
                <p>利用者が変更後も本サービスを利用した場合、変更後の利用規約に同意したものとみなします。</p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">第11条　準拠法・管轄</h2>
            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>本利用規約の解釈および適用については、日本法を準拠法とします。</p>
                <p>本サービスに関して利用者と運営者との間で紛争が生じた場合には、運営者の所在地を管轄する裁判所を第一審の専属的合意管轄裁判所とします。</p>
            </div>
        </section>

        <p class="pt-4 text-right text-xs text-gray-400">
            制定日：2026年6月3日
        </p>

    </article>
</div>
@endsection