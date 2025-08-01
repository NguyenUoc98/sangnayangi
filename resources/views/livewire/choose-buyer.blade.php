<div>
    <div wire:ignore class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center bg-white sm:rounded-lg md:p-6 p-4 shadow-md">
            <p class="text-3xl font-bold mb-6 text-center">Ai sẽ là người may mắn của ngày hôm nay?</p>
            <table cellpadding="0" cellspacing="0" border="0" class="mx-auto">
                <tr>
                    <td width="438" height="582"
                        class="the_wheel bg-[url('/images/wheel_back.png')] bg-no-repeat bg-center">
                        <canvas id="canvas" width="434" height="434" class="inline">
                            <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please
                                try another.</p>
                        </canvas>
                    </td>
                </tr>
            </table>
            @if(auth()->user()->hasAccess('platform.systems.users'))
                <button
                    id="spin_button"
                    class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-primary shadow-md hover:bg-primary-darker mt-4"
                    onclick="startSpin()">
                    Quay thôi
                </button>
            @endif
        </div>
    </div>

    @push('script')
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
        <script src="{{ asset('js/Winwheel.min.js') }}"></script>
        <script>
            @if(auth()->user()->hasAccess('platform.systems.users'))
            let option = {
                'type': 'spinToStop',
                'duration': 30,
                'spins': {{ count($userTodays) }},
                'callbackFinished': alertPrize,
                'callbackSound': playSound,
                'soundTrigger': 'pin'
            };
            @else
            let option = {
                'type': 'spinToStop',
                'duration': 40,
                'spins': {{ count($userTodays) }},
                'callbackSound': playSound,
                'soundTrigger': 'pin'
            };
            @endif

            let theWheel = new Winwheel({
                'numSegments': {{ count($userTodays) }},
                'outerRadius': 215,
                'textFontSize': 14,
                'segments': {!! json_encode($userTodays) !!},
                'animation': option,
                'pins':
                    {
                        'number': {{ count($userTodays) * 2 }}
                    }
            });

            let audio = new Audio("{{ asset('asset/tick.mp3') }}");

            function playSound() {
                audio.pause();
                audio.currentTime = 0;
                audio.play();
            }

            function alertPrize(indicatedSegment) {
                Swal.fire({
                    html: '<p class="text-xl text-center">Người được chọn</p>' + '<p class="font-bold text-2xl text-center">' + indicatedSegment.text + '</p>',
                    width: 600,
                    padding: '3em',
                    color: '#00a888',
                    background: '#fff url(/images/bg.png)',
                    backdrop: `
                                rgb(0, 168, 136, 0.4)
                                url("/images/nyan-cat.gif")
                                left bottom
                                no-repeat
                              `,
                    showConfirmButton: false
                });
                Livewire.emit('submit-buyer', indicatedSegment.id);
            }

            let wheelSpinning = false;

            function startSpin() {
                Livewire.emit('start-spinner');
                if (wheelSpinning == false) {
                    theWheel.animation.spins = 30;

                    $('#spin_button').attr('disabled', 'disabled');
                    $('#spin_button').addClass('bg-primary-darker');
                    $('#spin_button').removeClass('bg-primary');

                    theWheel.startAnimation();
                    wheelSpinning = true;
                }
            }

            function resetWheel() {
                theWheel.stopAnimation(false);
                theWheel.rotationAngle = 0;
                theWheel.draw();
                wheelSpinning = false;
            }
        </script>
        <script type="module">
            Echo.channel(`spinner.start`)
                .listen('.SpinnerStart', (e) => {
                    console.log(e);
                    theWheel.animation.spins = 30;
                    theWheel.startAnimation();
                });
        </script>
    @endpush
</div>
