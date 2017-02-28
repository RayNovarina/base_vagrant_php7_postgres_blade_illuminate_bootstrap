@extends('base')

      @section('browsertitle')
        Acme: Home
      @stop

      @section('pagecss')
        <style>
          .pagecontainer {
            padding: 40px;
            text-align: center;
          }
          .carousel-inner img {
            width: 100%;
            height: auto;
          }
          .empty-well {
            background: transparent;
          }
          .bigger-icon {
            font-size: 48px;
          }
        </style>
      @stop

      @section('content')
      
      <div class="row">
        <div class="col-md-4 well text-center">
          <h3>About</h3>

          <span class="glyphicon glyphicon-globe bigger-icon" aria-hidden="true"></span>

          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="col-md-4 well empty-well text-center">
          <h3>Tours</h3>

          <span class="glyphicon glyphicon-eye-open bigger-icon" aria-hidden="true"></span>

          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="col-md-4 well text-center">
          <h3>Contact</h3>

          <span class="glyphicon glyphicon-earphone bigger-icon" aria-hidden="true"></span>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </div>
      @stop

      @section('bottomjs')
      <script>
        /*$(document).ready(function(){
          alert('home page ready');
        });*/
      </script>
      @stop
