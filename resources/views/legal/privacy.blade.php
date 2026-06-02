@extends('layouts.site')

@section('title', 'プライバシーポリシー | '.config('app.name'))

@section('content')
<div class="mx-auto max-w-4xl">

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-indigo-900">
            プライバシーポリシー
        </h1>

        <p class="mt-3 text-sm text-gray-500">
            みんなの声辞典における個人情報の取り扱いについてご確認ください。
        </p>

        <p class="mt-2 text-xs text-gray-400">
            制定日：2026年6月3日
        </p>
    </div>

    <article class="space-y-6">

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <div class="space-y-3 leading-7 text-gray-700">
                <p>
                    みんなの声辞典（以下「本サービス」といいます。）は、利用者の個人情報の重要性を認識し、個人情報保護に関する法令を遵守するとともに、適切な取得、利用および管理に努めます。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第1条　個人情報の定義
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    本ポリシーにおける個人情報とは、個人情報保護法に定める個人情報をいい、氏名、ニックネーム、メールアドレス、生年その他の記述等により特定の個人を識別できる情報をいいます。
                </p>

                <p>
                    また、本サービスの性質上、疾病や治療に関する情報など、要配慮個人情報に該当する情報を取得する場合があります。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第2条　取得する情報
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    本サービスでは、以下の情報を取得することがあります。
                </p>

                <ul class="list-disc space-y-2 pl-6">
                    <li>氏名またはニックネーム</li>
                    <li>メールアドレス</li>
                    <li>年代算出のための生年月情報</li>
                    <li>診断時期</li>
                    <li>治療内容</li>
                    <li>投稿内容</li>
                    <li>お問い合わせ内容</li>
                    <li>本サービスの利用状況に関する情報</li>
                </ul>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第3条　利用目的
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    取得した情報は、以下の目的のために利用します。
                </p>

                <ul class="list-disc space-y-2 pl-6">
                    <li>本サービスの提供および運営</li>
                    <li>利用者の本人確認</li>
                    <li>投稿内容の管理および公開</li>
                    <li>利用者からのお問い合わせへの対応</li>
                    <li>本サービスの改善および品質向上</li>
                    <li>不正利用の防止</li>
                    <li>法令等への対応</li>
                </ul>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第4条　個人情報の管理
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    運営者は、個人情報の漏えい、紛失、改ざんおよび不正アクセスを防止するため、適切な安全管理措置を講じます。
                </p>

                <p>
                    利用者のパスワードは暗号化して管理されます。
                </p>

                <p>
                    運営者は、取得した個人情報について、利用目的の達成に必要な範囲で適切に管理し、不要となった場合には適切な方法により削除または廃棄します。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第5条　第三者提供
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    運営者は、次の場合を除き、利用者の個人情報を第三者に提供しません。
                </p>

                <ul class="list-disc space-y-2 pl-6">
                    <li>利用者本人の同意がある場合</li>
                    <li>法令に基づく場合</li>
                    <li>人の生命、身体または財産の保護のために必要がある場合</li>
                    <li>公衆衛生の向上のために特に必要がある場合</li>
                </ul>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第6条　投稿内容について
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    本サービスでは、利用者が投稿した体験談やコメントを公開する場合があります。
                </p>

                <p>
                    投稿は原則として匿名で公開されますが、利用者が投稿内容に個人を特定できる情報を記載した場合、その情報が公開される可能性があります。
                </p>

                <p>
                    利用者は、投稿にあたり、自身および第三者の個人情報の保護に十分配慮するものとします。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第7条　Cookie等の利用について
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    本サービスでは、利便性向上およびサービス改善のため、Cookieその他これに類する技術を利用する場合があります。
                </p>

                <p>
                    利用者は、ブラウザの設定によりCookieの利用を制限または拒否することができます。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第8条　個人情報の開示、訂正および削除
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    利用者は、自己の個人情報について、開示、訂正、追加、削除または利用停止を求めることができます。
                </p>

                <p>
                    運営者は、法令に従い合理的な範囲で対応します。
                </p>

                <p>
                    また、利用者は、本サービス上の機能または運営者への連絡により、アカウントの削除を求めることができます。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第9条　プライバシーポリシーの変更
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    運営者は、必要に応じて本ポリシーを変更することがあります。
                </p>

                <p>
                    変更後のプライバシーポリシーは、本サービス上に掲載した時点から効力を生じるものとします。
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-indigo-900">
                第10条　お問い合わせ
            </h2>

            <div class="mt-4 space-y-3 leading-7 text-gray-700">
                <p>
                    個人情報の取り扱いに関するお問い合わせ、開示、訂正または削除のご依頼については、下記までご連絡ください。
                </p>

                <div class="rounded-lg bg-indigo-50 p-4 text-sm text-indigo-900">
                    <p class="font-semibold">お問い合わせ先</p>
                    <p class="mt-2">Survivor+</p>
                    <p>メールアドレス：survivorplus@gmail.com</p>
                </div>
            </div>
        </section>

        <p class="pt-4 text-right text-xs text-gray-400">
            制定日：2026年6月3日
        </p>

    </article>
</div>
@endsection