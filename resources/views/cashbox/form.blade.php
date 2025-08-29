        <form action="{{ route('cashbox.save', ['item' => $item?->id]) }}" class="saveForm">
            <div class="form-items">
                <div class="form-item">
                    <label for="">Xərc növü</label>
                    <select name="expense_type_id" id="">
                        <option>Seçin</option>
                        @foreach ($expenseTypes as $expense)
                            <option value="{{ $expense->id }}">{{ $expense->title }}</option>
                        @endforeach
                    </select>
                </div>
                
            <div class="form-item">
                <label for="">Miqdar</label>
                <div class="form-input">
                    <input name="price" class="note" type="number" any=".01"/>
                </div>
            </div>
            <div class="form-item" style="grid-column:span 2">
            <button class="submit" type="submit">Əlavə et</button>
            </div>
        </form>
