@extends('layouts.adminLayout.admin_design')
@section('content')


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categores</a> <a href="#" class="current">Validation</a> </div>
    <h1>Edit Category</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Category</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/edit-category/'.$categoriesDetails->id)}}" name="add_category" id="add_category" novalidate="novalidate"> {{ csrf_field()}}
    

              <div class="control-group">
                <label class="control-label">Category Name</label>
                <div class="controls">
                  <input type="text" name="category_name" id="category_name" value='{{$categoriesDetails->name}}'>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Category Level</label>
                <div class="controls">
                  <select name="parent_id" style="width:220px;">
                    <option value="0">Main Category </option>
                    @foreach($levels as $val)
                    <option value="{{$val->id}}"@if($val->id == $categoriesDetails->parent_id) selected @endif>{{$val->name}}</option>
                    @endforeach

                  </select>
                </div>
              </div>
           
              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  
                  <textarea name="description" id="description" >{{$categoriesDetails->description}}</textarea>
                </div>
              </div>
           
              <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                  <input type="text" name="url" id="url" value='{{$categoriesDetails->name}}'>
                </div>
              </div>
           
            
              <div class="form-actions">
                <input type="submit" value="Add Category" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>

@endsection