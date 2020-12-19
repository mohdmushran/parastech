<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <div class="mt-8 text-2xl">
                        Welcome to your subscription manager!
                    </div>

                    <div class="mt-6 text-gray-500">
                        Enter details below to start the subscription!
                    </div>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laravel.com/docs">VIP Membership</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                By subscribing to our VIP plan you're becoming a paid member of our application, this payment will be recurring and will be billed automatically every month.
                            </div>

                            <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>$20 / month</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        
                        @if (auth()->user()->subscribed(env('APP_SUBSCRIPTION_NAME')))
                            <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laracasts.com">You're subscribed to VIP Plan</a></div>
                        </div>
                        @else

                        <div class="ml-12">
                            <div class="block mb-4">
                                <x-jet-label for="Name" value="{{ __('Name') }}" />
                                <input id="card-holder-name" type="text" class="block mt-1 w-full">
                            </div>

                            <!-- Stripe Elements Placeholder -->
                            <div id="card-element"></div>

                            <x-jet-button id="card-button" class="btn btn-dark mt-4" data-secret="{{ $intent->client_secret }}">
                                Update Payment Method
                            </x-jet-button>
                        </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

@if (!auth()->user()->subscribed(env('APP_SUBSCRIPTION_NAME')))
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');


    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            // Display "error.message" to the user...
            alert(error.message);
        } else {
            // The card has been verified successfully...
            window.location = '/user/subscribe/' + setupIntent.payment_method;
        }
    });
</script>
@endif

</x-app-layout>
