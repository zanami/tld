<section class="py-12 bg-neutral-200">
    <div class="container mx-auto px-4">
        <!-- Заголовок блока -->
        <div class="text-center">
            <h2 class="text-3xl md:text-5xl tracking-tight mt-12">
                Продажа и сервис вилочных погрузчиков
            </h2>
            <p class="mt-4 text-base md:text-xl text-black/80">
                Вся техника продается с гарантией, осуществляем ТО и ремонт
            </p>
        </div>

        <!-- Карточки -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Карточка 1 -->
            <article class="flex flex-col">
                <!-- Изображение -->
                <a href="/oborudovanie-bu/?tpl=new" class="relative overflow-hidden rounded-2xl aspect-[4/3]">
                    <img
                        src="<?=SITE_TEMPLATE_PATH?>/assets/images/front/forklift.jpg"
                        alt=""
                        class="absolute inset-0 w-full h-full object-cover"
                    />

                    <!-- Градиент -->
                    <div
                        class="absolute inset-0"
                        style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.5));"
                    ></div>

                    <!-- Текст поверх -->
                    <div class="relative z-10 p-6 sm:p-8">
                        <h3 class="text-white text-3xl md:text-4xl leading-tight">
                            Купить<br class="hidden sm:block" />
                            погрузчик
                        </h3>
                    </div>
                </a>

                <!-- Описание -->
                <p class="mt-6 text-base md:text-xl font-light leading-relaxed text-black">
                    Купить вилочные погрузчики UN Forklift 1−10 т (дизель/бензин/электро)
                    и складская техника XILIN в наличии — готовые решения для вашего склада с быстрой отгрузкой!
                </p>

                <!-- Кнопка -->
                <a
                    href="/oborudovanie-bu/?tpl=new"
                    class="inline-flex items-center justify-center mt-8 py-3 px-10 rounded-xl
                 bg-orange-400 hover:bg-orange-500 active:bg-orange-600
                 text-black uppercase tracking-wide
                 transition-colors w-fit self-start"
                >
                    Посмотреть технику
                </a>
            </article>

            <!-- Карточка 2 -->
            <article class="flex flex-col">
                <!-- Изображение -->
                <a href="/services/garantiynoe-i-sevrisnoe-obsluzhivanie/" class="relative overflow-hidden rounded-2xl aspect-[4/3]">
                    <img
                        src="<?=SITE_TEMPLATE_PATH?>/assets/images/front/madam.jpg"
                        alt=""
                        class="absolute inset-0 w-full h-full object-cover"
                    />

                    <!-- Градиент -->
                    <div
                        class="absolute inset-0"
                        style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.5));"
                    ></div>

                    <!-- Текст поверх -->
                    <div class="relative z-10 p-6 sm:p-8">
                        <h3 class="text-white text-3xl md:text-4xl leading-tight">
                            Заказать сервисное<br class="hidden sm:block" />
                            обслуживание
                        </h3>
                    </div>
                </a>

                <!-- Описание -->
                <p class="mt-6 text-base md:text-xl font-light leading-relaxed text-black">
                    Мы позаботимся о вашем погрузчике — техническая поддержка,
                    гарантийное и постгарантийное обслуживание.
                </p>

                <!-- Кнопка -->
                <a
                    href="/services/garantiynoe-i-sevrisnoe-obsluzhivanie/"
                    class="inline-flex items-center justify-center mt-8 px-10 py-3 rounded-xl
                 bg-orange-400 hover:bg-orange-500 active:bg-orange-600
                 text-black uppercase tracking-wide
                 transition-colors w-fit self-start"
                >
                    Записаться на сервис
                </a>
            </article>

        </div>
    </div>
</section>