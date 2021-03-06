@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <div class="card">
          <div class="card-header">
              登録画面 {{ $calendar->getCreateTitle() }}
          </div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif

            <form action="{{ route('store_task') }}" method="POST">
              @csrf

              <div class="form-group"> 
                <label for="active_date" class="control-label">日付</label>
                <input type="text" name="active_date" class="form-control" id="active_date" value="{{ $calendar->getCreateFormDate() }}">
              </div>
              
              <div class="form-group">
                <label for="title" class="control-label">タイトル</label>
                <input type="text" class="form-control" name="title" id="title">
              </div>

              <div class="form-group">
                <label for="status">状態</label>
                <select name="status" class="form-control" id="status">
                  <option value="良い">良い</option>
                  <option value="普通">普通</option>
                  <option value="悪い">悪い</option>
                </select>
              </div>

              <div class="form-group">
                <label for="description">詳細</label>
                <textarea name="description" class="form-control" rows="8" cols="80" id="description"></textarea>
              </div>

              <button type="submit" value="登録" class="btn btn-primary">登録</button>
            </form>
            
            <a href="{{ route('calendar') }}" class="btn btn-info">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection