
@php($TODAY = date("Y-m-d H:i:s"))

@php($StoreID=0)

@php($CustomerType='') @php($CustomerID=0) 
@php($FirstName='')    @php($FullName='')
@php($ReferenceNo='')  @php($OrderDate='')

@php($MobileNo='')       @php($EmailAddress='')        

@php($Address='')      
@php($City='')         @php($State='')        
@php($Postal='')       @php($Country='')


@php($ModeOfPayment='') @php($StoreCurrencyCode='')

@php($TotalAmountDue = 0)
@php($Total=0)           @php($VoucherAmount=0)
@php($EwalletPayment=0)  @php($DiscountAmount=0)

@php($OrderInstruction='')  

@If(isset($OrderInfo) > 0)  
    @php($ReferenceNo=$OrderInfo->order_number)  
    @php($ModeOfPayment=$OrderInfo->payment_method)
    @php($OrderDate=date_format(date_create($OrderInfo->order_date),'M. j, Y '))
                 
    @php($FullName=$OrderInfo->customer_name)
            
    @php($MobileNo=$OrderInfo->customer_contact_number)       
    @php($EmailAddress=$OrderInfo->customer_email)        
    
    @php($Address=$OrderInfo->customer_delivery_adress)      
  
    @php($TotalAmountDue = $OrderInfo->gross_amount)    
    @php($Total=$OrderInfo->net_amount) 
    
    @php($VoucherAmount=0)
    @php($DiscountAmount=$OrderInfo->discount_amount)    
    
    @php($EwalletPayment=$OrderInfo->ecredit_amount)
    
        
@endif


  <div>
    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' align='center' cellspacing='0' cellpadding='0' border='0'>
                   <tbody>
                      <tr>
                         <td align='center' height='20' style='font-size:1px;line-height:1px'>&nbsp;</td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                 <tr>
                                   <td>
                                     <center style='background: #21395f;'>
                                       <img src='https://beta.ebooklat.phr.com.ph/storage/logos/1707185818_webfocus-logo.png' alt='' border='0' width='180' height='90'>
                                     </center>
                                   </td>
                                 </tr>
                                 <tr>
                                    <td height='10' style='font-size:1px;line-height:20px;background-color:#14294b'>&nbsp;</td>
                                 </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;text-align:left;line-height:18px'>
                                                  Dear <b>{{$FullName}}</b>,
                                                 </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;text-align:left;line-height:18px'>
                                                     
                                                   We would like to inform you that your order <span style='color:#21395f'><b>#{{$ReferenceNo}}</b></span> has been placed via  <b>{{$ModeOfPayment}}</b>. 
                                                  
                                                  <br>
                                                     If you have concerns with your purchase item, please contact our <b><a target='_blank' href='#'>Live Support Chat.</a> </b> or email us at [Email Support]
                                                   
                                                    <br>
                                                    <br>
                                                    Thank you for shopping with us!
                                                 </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                   <tr>
                                     <td width='100%' height='1' bgcolor='#ffffff' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' align='center' cellspacing='0' cellpadding='0' border='0'>
                   <tbody>
                        <tr>
                           <td width='100%' height='1' bgcolor='#e0e0e0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                        </tr>
                        <tr>
                           <td align='center' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                        </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px'>
                                                   <table width='px' align='left'>
                                                   <tbody>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px'> 
                                                       </td>
                                                     </tr>
                                                     <tr>
                                                        <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#21395f;font-size:13px;font-weight:bold'>
                                                        ORDER DETAILS:
                                                       </td>
                                                     </tr>
                                                  </tbody>
                                                </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>

                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>

                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px'>
                                                   <table width='px' align='left'>
                                                   <tbody>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;'></td>
                                                     </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                       Order No: 
                                                    </td>
                                                    <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>
                                                       {{$ReferenceNo}}
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      Order Date: 
                                                    </td>
                                                    <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      {{$OrderDate}}
                                                  </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table width='600' cellpadding='0' cellspacing='0' border='0' align='left'>
                               <tbody>

                                @php($ImgPath='')                                 
                                @php($ProductName='')
                                @php($Qty=0)
                                @php($Price=0)
                                @php($IsRedeemable=0)
                                @php($ItemSubTotal=0)
                                @php($ItemTotal=0)
                                                                  
                                 @If(count($OrderItem))                                    
                                    @foreach($OrderItem as $order_item)

                                    @php($ImgPath='https://beta.ebooklat.phr.com.ph/storage/products/'.$order_item->image_path)
                                    @php($ProductName=$order_item->product_name)
                                    @php($Qty=1)
                                    @php($Price=$order_item->price)                                                                        
                                                                                                                      
                                  <tr>
                                     <td>
                                        <table width='180' align='left' border='0' cellpadding='0' cellspacing='0'>
                                           <tbody>
                                              <tr>
                                                 <td width='160' height='120' align='left' style='padding-left:20px'>
                                                    <img src='{{$ImgPath}}' alt='' border='0' width='90' height='100' style='display:block;border:none;outline:none;text-decoration:none'>
                                                 </td>
                                              </tr>
                                           </tbody>
                                        </table>

                                        <table align='left' border='0' cellpadding='0' cellspacing='0'>
                                           <tbody>
                                              <tr>
                                                 <td width='100%' height='15' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>

                                        <table width='280' align='left' border='0' cellpadding='0' cellspacing='0'>
                                           <tbody>
                                              <tr>
                                                 <td>
                                                    <table width='100%' align='left' border='0' cellpadding='0' cellspacing='0'>
                                                       <tbody>
                                                          <tr>
                                                              <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;text-align:left;line-height:px;padding-left:10px;font-weight:bold;'>
                                                                {{$ProductName}}
                                                             </td>
                                                          </tr>
                                                          <tr>
                                                             <td width='' height='15' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                                          </tr>
                                                           <tr>
                                                               <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;text-align:left;line-height:px'>
                                                                   <table width='100%' align='left'>
                                                                       <tbody>
                                                                         <tr>
                                                                           <td style='text-align:left;padding-left:10px;font-family:Helvetica,arial,sans-serif;color:#747474;font-size:13px;white-space:nowrap;width:80px'>
                                                                             Quantity: 
                                                                         </td>
                                                                           <td style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#747474;font-size:13px'>
                                                                           {{$Qty}}
                                                                         </td>
                                                                       </tr>
                                                                       <tr>
                                                                           <td style='text-align:left;padding-left:10px;font-family:Helvetica,arial,sans-serif;color:#747474;font-size:13px;white-space:nowrap;width:80px'>
                                                                           Price: 
                                                                         </td>
                                                                           <td style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#747474;font-size:13px'>
                                                                                                                                                        
                                                                               Php {{number_format($Price,2)}}
                                                                            
                                                                         </td>
                                                                       </tr>
                                                                   </tbody>
                                                                 </table>
                                                               </td>
                                                           </tr>
                                                          <tr>
                                                             <td width='100%' height='15' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                                          </tr>
                                                       </tbody>
                                                    </table>
                                                 </td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>

                                @php($ItemTotal=$ItemTotal+ ($Price * $Qty))                                      

                              @endforeach

                            @endif

                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px;'>
                                                     <table width='' align='left' style='margin-left:170px;'>
                                                     <tbody>
                                                       <tr>
                                                         <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px'>
                                                         </td>

                                                       </tr>
                                                       <tr>
                                                         <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>      
                                                          Total Amout Due: 
                                                         </td>
                                                         <td style='text-align:right;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>
                                                        {{$StoreCurrencyCode}} {{number_format($TotalAmountDue,2)}}
                                                       </td>
                                                      </tr>
                                                      <tr>
                                                        <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>Less: 
                                                        </td>
                                                      </tr>
                                                        <tr>
                                                        <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>Voucher Amount: </td>
                                                        <td style='text-align:right;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>
                                                          {{$StoreCurrencyCode}} {{number_format($DiscountAmount,2)}}
                                                        </td>
                                                      </tr>
                                                      <!--  <tr>-->
                                                      <!--  <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>Discount: </td>-->
                                                      <!--  <td style='text-align:right;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>-->
                                                      <!-- {{$StoreCurrencyCode}} {{number_format($DiscountAmount,2)}}-->
                                                      <!--</td>-->
                                                      <!--</tr>-->
                                                      <tr>
                                                        <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                        Used Ewallet: </td>
                                                        <td style='text-align:right;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>
                                                        {{$StoreCurrencyCode}} {{number_format($EwalletPayment,2)}}
                                                      </td>
                                                      </tr>

                                                      <tr style='border-top: 2px solid lightgray;'>
                                                        <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                          <b>Sub Total:</b>
                                                        </td>
                                                        <td style='text-align:right;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                          <b>{{$StoreCurrencyCode}} {{number_format($Total,2)}}</b>
                                                        </td>

                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
      </table>"


     <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' align='center' cellspacing='0' cellpadding='0' border='0'>
                   <tbody>
                      <tr>
                         <td align='center' height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                      </tr>
                       <tr>
                         <td width='100%' height='1' bgcolor='#e0e0e0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px'>
                                                   <table width='px' align='left'>
                                                   <tbody>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px'> </td>
                                                     </tr>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:13px;font-weight:bold'>
                                                      Your purchase information:</td>
                                                     </tr>
                                                  </tbody>
                                                </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px'>
                                                   <table width='px' align='left'>
                                                   <tbody>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;'> 
                                                       </td>
                                                     </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      Name:</td>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;vertical-align:top'>{{$FullName}}</td>
                                                    </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      Delivery Address:</td>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                        {{$Address}}
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      Phone Number:
                                                    </td>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      {{$MobileNo}}
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      Email Address:
                                                    </td>
                                                      <td style='text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#747474;white-space:nowrap;vertical-align:top'>
                                                      {{$EmailAddress}}
                                                    </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td height='0' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:13px;color:#889098;text-align:center;line-height:16px'>
                                                   <table width='px' align='left'>
                                                   <tbody>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px'> 
                                                       </td>
                                                     </tr>
                                                     <tr>
                                                       <td colspan='2' style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:13px;font-weight:bold'>IMPORTANT REMINDERS:</td>
                                                     </tr>
                                                     <tr>
                                                       <td style='text-align:left;font-family:Helvetica,arial,sans-serif;color:#747474;font-size:13px;'>
                                                         <ul>
                                                                                                              
                                                           <li>
                                                             Keep your invoice and original packaging in case you need to return, or request for a replacement.
                                                           </li>                                           
                                                           <li>
                                                              You can't request for order cancellation, once the order has been out for delivery.
                                                           </li>
                                                         </ul>
                                                       </td>
                                                     </tr>
                                                  </tbody>
                                                </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                 <td width='100%' height='' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>

    <div style='width:100%;height:15px;display:block' align='center'>
      <div style='width:100%;max-width:600px;height:1px;border-top:1px solid #e0e0e0'>
        &nbsp;
      </div>
    </div>
 
    <table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
       <tbody>
          <tr>
             <td>
                <table width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                   <tbody>
                      <tr>
                         <td width='100%'>
                            <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center'>
                               <tbody>
                                  <tr>
                                     <td>
                                        <table width='560' align='center' cellpadding='0' cellspacing='0' border='0'>
                                           <tbody>
                                              <tr>
                                                 <td width='100%' height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                 <td style='font-family:Helvetica,arial,sans-serif;font-size:11px;color:#747474;text-align:left;line-height:100%'>
                                                   This is a system generated email. Please do not reply to this email.
                                                   Add us <span style='text-decoration:none;color:#772d6b'><b>  </b></span> to your address book.
                                                 </td>
                                              </tr>
                                           </tbody>
                                        </table>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td height='10' style='font-size:1px;line-height:1px'>&nbsp;</td>
                                  </tr>
                               </tbody>
                            </table>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </td>
          </tr>
       </tbody>
    </table>
</div>

