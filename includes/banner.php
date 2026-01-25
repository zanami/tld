<section class="w-full h-[400px] relative overflow-hidden">
    <!-- Background image -->
    <div
        class="absolute inset-0 bg-center bg-cover"
        style="background-image: url('<?=SITE_TEMPLATE_PATH?>/assets/images/front/big-banner.jpg');"
        aria-hidden="true"
    ></div>

    <!-- Gradient dark overlay -->
    <div
        class="absolute inset-0"
        style="background-image: linear-gradient(rgba(51, 51, 51, 0.1), rgba(51, 51, 51, 0.8));"
        aria-hidden="true"
    ></div>

    <!-- Content -->
    <div class="relative z-10 h-full flex items-center">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl text-white">
                <h2 class="text-4xl md:text-5xl font-semibold tracking-tight">
                    Предложение месяца!
                </h2>

                <p class="mt-4 text-lg md:text-xl font-semibold leading-snug text-white/90">
                    С 1 апреля — лучшие предложения<br />
                    на складскую технику. Покупайте по лучшей цене!
                </p>

                <a
                    href="/oborudovanie-bu/?tpl=new"
                    class="inline-flex items-center justify-center mt-8 h-14 px-10 rounded-xl
                 bg-orange-400 hover:bg-orange-500 active:bg-orange-600
                 text-black uppercase tracking-wide
                 transition-colors"
                >
                    Выбрать технику
                </a>
            </div>
        </div>
    </div>
</section>