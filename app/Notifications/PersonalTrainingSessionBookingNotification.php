<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;



class PersonalTrainingSessionBookingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $notifydata;
    public function __construct($notifydata)
    {
        $this->notifydata=$notifydata;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      //Log::debug(" Mail ".print_r($this,true));
      if($this->notifydata['status']=='Book PT Session By Admin To Trainer' || $this->notifydata['status']=='Single PT Schedule Delete By Admin To Trainer' || $this->notifydata['status']=='Cancelled PT Session By Admin To Trainer')
        {
          return (new MailMessage)->view(
        'emails.ptsessionrequestemailtotrainer',
        [
      'enquiredTime' => Carbon::now(),
      'trainer_name'=>$this->notifydata['trainer_name'],
      'trainer_email'=>$this->notifydata['trainer_email'],
      'trainer_phone'=>$this->notifydata['trainer_phone'],
      'status'=>$this->notifydata['status'],
      'url'=>$this->notifydata['url'],
      'session_booked_on'=>$this->notifydata['session_booked_on'],
      'session_booking_date'=>$this->notifydata['session_booking_date'],
      'session_booking_time'=>$this->notifydata['session_booking_time'],
      'session_booking_day'=>$this->notifydata['session_booking_day'],
      'cancelled_reason'=>$this->notifydata['cancelled_reason'],                   
      'schedule_address'=>$this->notifydata['schedule_address'],
      'trainer_id'=>$this->notifydata['booked_by_id']
      ]);
        }
        
        else if($this->notifydata['status']=='Boocked PTSession by Customer send to Trainer')
        {
         return (new MailMessage)->view(
                  'emails.ptsessionrequestemailtotrainer',
                  [
                'enquiredTime' => Carbon::now(),
                'customer_name'=>$this->notifydata['customer_name'],
                'trainer_name'=>$this->notifydata['trainer_name'],
                'status'=>$this->notifydata['status'],
                'url'=>$this->notifydata['url'],
                'session_booking_date'=>$this->notifydata['session_booking_date'],
                'session_booking_time'=>$this->notifydata['session_booking_time'],                   
                'schedule_address'=>$this->notifydata['schedule_address']
                
                 ]);
        }
        else if($this->notifydata['status']=='Cancelled PT Session By Customer send to Trainer')
        {
         return (new MailMessage)->view(
                  'emails.ptsessionrequestemailtotrainer',
                  [
                'enquiredTime' => Carbon::now(),
                'customer_name'=>$this->notifydata['customer_name'],
                'trainer_name'=>$this->notifydata['trainer_name'],
                
                'status'=>$this->notifydata['status'],
                'url'=>$this->notifydata['url'],
                'session_booked_on'=>$this->notifydata['session_booked_on'],
                'session_booking_date'=>$this->notifydata['session_booking_date'],
                'session_booking_time'=>$this->notifydata['session_booking_time'],
                'session_booking_day'=>$this->notifydata['session_booking_day'],
                                 
                'schedule_address'=>$this->notifydata['schedule_address']
                
                 ]);
        }

        else
        {
      return (new MailMessage)->view(
        'emails.ptsessionrequestemailtotrainer',
        [
      'enquiredTime' => Carbon::now(),
      'trainer_name'=>$this->notifydata['trainer_name'],
      'trainer_email'=>$this->notifydata['trainer_email'],
      'trainer_phone'=>$this->notifydata['trainer_phone'],
      'status'=>$this->notifydata['status'],
      'url'=>$this->notifydata['url'],
      'session_booked_on'=>$this->notifydata['session_booked_on'],
      'session_booking_date'=>$this->notifydata['session_booking_date'],
      'session_booking_time'=>$this->notifydata['session_booking_time'],
      'session_booking_day'=>$this->notifydata['session_booking_day'],
      'cancelled_reason'=>$this->notifydata['cancelled_reason'],                   
      'schedule_address'=>$this->notifydata['schedule_address']                   
      ]);
    }
  }
}