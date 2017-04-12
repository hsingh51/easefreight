@extends('layouts.app')

@section('content')
  <?php //dd($data); ?>
  <div class="container-fluid airShpmain">  
    <div class="container">
      <div class="row">
        <div class="col-md-12 booking">
          <div class="panel panel-default">
            <div class="panel-heading">{{ trans('messages.Booking') }}</div>
            <div class="panel-body">
              <div class="col-md-12 addition"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans('messages.Quote ID') }}</th>
                      <th>{{ trans('messages.Origin') }}</th>
                      <th>{{ trans('messages.Destination') }}</th>
                      <th></th>
                      <th></th>
                    </tr>
                    <?php 
                      if(@$data){ 
                        foreach($data as $value){ 
                          $url = $value->url;
                          if(strpos($value->url, "www.easefreight.com/ease-freight/public/") == "7"){
                            $url = str_replace("http://www.easefreight.com/ease-freight/public/", "", $value->url);
                          }
                          if(strpos($value->url, "://easefreight.com/ease-freight/public/")){
                            $url = str_replace("http://easefreight.com/ease-freight/public/", "", $value->url);
                          }
                          echo "<tr><td>".$value->search_id."</td>
                            <td>".$value->origin->path."</td>
                            <td>".$value->destination->path."</td>
                            <td class='userfont'><a href='".BASE_URL.'/'.$url."' class='btn btn-info btncolor' >";?>{{ trans('messages.view') }} <?php echo "</a> </td><td>
                              <a href='".newurl('/quote/delete/'.$value->search_id)."' class='btn btn-info btncolor' >";?>{{ trans('messages.delete') }} <?php echo "</a> </td><td>";
                        }
                      }
                      else{ 
                            echo "<tr><td colspan='6' align='center'>";?>
          							    {{ trans('messages.no_record_found') }}
          					<?php 
                            echo "</td></tr>"; 
                          }
                    ?>
                </table>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 box-body  userfont footerbtns">
              <a href="#" class="inputtype">{{ trans('messages.QuestionS') }}?</a>   
              <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/>    
            </div>
          </div>
        </div>
      </div><!-- Close container-fluid -->
    </div>
  </div>

@endsection