{{--
<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
--}}
{{--            @include('shared._vote', [--}}{{--

--}}
{{--                'model' => $answer--}}{{--

--}}
{{--            ])--}}{{--

--}}
{{--            @include('shared._accept', [--}}{{--

--}}
{{--                'model' => $answer--}}{{--

--}}
{{--            ])--}}{{--

        <vote :model="{{ $answer }}" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing">
                <div class="form-group">
                   <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" @click="update" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan

                            @can('delete', $answer)
                                <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
--}}
{{--                                <form class="form-delete" method="post" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">--}}{{--

--}}
{{--                                    @method('DELETE')--}}{{--

--}}
{{--                                    @csrf--}}{{--

--}}
{{--                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure')">Delete</button>--}}{{--

--}}
{{--                                </form>--}}{{--

                            @endcan
                        </div>
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>
--}}
