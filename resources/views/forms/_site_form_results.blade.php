<div class="accordion" id="questionAccordion">
        @foreach($form->questions as $question)
        <div class="card">
            <div class="card-header" id="headingTwo">
                <div class="row p-2">
                    <h5>{{ $question->question }}</h5>
                    @if(!$form->is_anonymous && $question->has_options && $user && $user->isStaff)
                    <a href="#" class="ml-2 collapsed collapse-toggle" type="button" data-toggle="collapse" data-target="#question-{{$question->id}}" aria-expanded="false" aria-controls="question-{{$question->id}}">
                        (View Details)
                    </a>
                    @endif
                    @if(!$question->has_options)
                    <a href="#" class="ml-2 collapsed collapse-toggle" type="button" data-toggle="collapse" data-target="#question-{{$question->id}}" aria-expanded="false" aria-controls="question-{{$question->id}}">
                        (View Answers)
                    </a>
                    @endif
                </div>
                @php $totalAnswers = $question->answers->count(); @endphp
                <h6><b>Total answers: {{ $totalAnswers }}</b></h6>
                @if($question->options->count() > 0)
                @foreach($question->options as $option)
                @php $optionAnswers = $option->answers->count(); @endphp
                {{ $option->option }}
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar @if($totalAnswers > 0 && $optionAnswers / $totalAnswers * 100 == 0) ml-2 text-dark @endif" role="progressbar" style="width:{{ ($totalAnswers > 0) ? $optionAnswers / $totalAnswers * 100 : 0 }}%;" aria-valuenow="{{ $optionAnswers }}" aria-valuemin="0" aria-valuemax="{{ $totalAnswers }}">{{ $optionAnswers }}</div>
                </div>
                @endforeach
                @else
                View answers to see what people had to say!
                @endif
            </div>
            <div id="question-{{$question->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#questionAccordion">
                <div class="card-body p-lg-3 p-0">
                    @if($question->has_options)
                        @foreach($question->options as $option)
                        <b>{{ $option->option }} :</b>
                        <div>
                            @foreach($option->answers as $answer) <span class="mr-2">{!! $answer->user->displayName !!}</span> @endforeach
                        </div>
                        @endforeach
                    @else
                        @foreach($question->answers as $answer)
                            @if($answer->answer)
                            <div>
                            @if(!$form->is_anonymous && $user && $user->isStaff)<b>{!! $answer->user->displayName !!}:</b>@endif
                                <div class="p-2 border">{{ $answer->answer }}</div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>

