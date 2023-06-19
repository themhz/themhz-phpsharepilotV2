<?php
use SharePilotV2\Libs\YoutubeService;
use SharePilotV2\Config;
use SharePilotV2\Models\Urls;
use SharePilotV2\Models\Socials;
use SharePilotV2\Models\Scheduled_posts;
use SharePilotV2\Models\Channels;
use SharePilotV2\Models\Channel_social_keys;
use SharePilotV2\Components\ResponseHandler;
use SharePilotV2\Components\RequestHandler;

 class Controller{

    public function get()
    {
        $c = new Channels();
        $data = $c->select();
        ResponseHandler::respond($data);
    }

     public function delete()
     {
         $c = new Channels();
         $data = $c->delete(["id="=>RequestHandler::get("id")]);
         ResponseHandler::respond($data);

     }

     public function put(){
         $c = new Channels();
         $c->id = RequestHandler::get("id");
         $c->name = RequestHandler::get("name");
         $data = $c->update();
         ResponseHandler::respond($data);

         $keylist = RequestHandler::get("keylist");
         $keys = new Channel_social_keys();

         $social_id = RequestHandler::get("social_id");
         $channel_id = RequestHandler::get("id");

         $keys->delete(["channel_id="=>$channel_id," and social_id="=>$social_id]);

         foreach ($keylist as $key){
             $keys->channel_id = $channel_id;
             $keys->social_id = $social_id;
             $keys->name =$key["name"];
             $keys->value =$key["value"];
             $keys->insert();
             //echo $key["name"].' '.$key["value"];
         }

       /*  $keys->name;
         $keys->value;
         print_r($keylist);*/


     }


     public function getsocials(){
        $s = new Socials();
         ResponseHandler::respond($s->select());
     }

     public function loadkeys(){
         $channelId = RequestHandler::get("channelId");
         $socialId = RequestHandler::get("socialId");

         $csk = new Channel_social_keys();

         ResponseHandler::respond($csk->select(["channel_id ="=>$channelId, " and social_id ="=>$socialId]));

     }
 }





 