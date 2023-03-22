<div class="list-icons">
    <a href="{{ route('transaction-payment.edit' , $id) }}"
       class="list-icons-item text-primary-600 pr-2"><i class="icon-pencil7"></i></a>
    @if(!$status)
        <form action="{{ route('transaction-payment.destroy' , $id) }}"
              method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn list-icons-item text-danger-600"
                    style="padding: 0;background: transparent; color: red"
                    onclick="return confirm('هل انت متاكد؟');">
                <i class="icon-trash"></i>
            </button>
        </form>
    @endif
</div>
