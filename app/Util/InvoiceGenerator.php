<?php

declare(strict_types=1);

namespace App\Util;

use Nette;


class InvoiceGenerator
{
    public function generateInvoice(int $id, int $amount): string {

        $currentDate = date("Y-m-d");
    
        $invoice = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .invoice {
                    border: 1px solid #ddd;
                    padding: 20px;
                    max-width: 600px;
                    margin: 0 auto;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                table, th, td {
                    border: 1px solid #ddd;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
        
        <div class="invoice">
            <h2>Invoice</h2>
            <p>Date: {$currentDate}</p>
        
            <div>
                <h3>Sender Details</h3>
                <p>Company: ABC Corp</p>
                <p>Address: 123 Main Street, Cityville</p>
                <p>Contact: info@abccorp.com</p>
            </div>
        
            <div>
                <h3>Receiver Details</h3>
                <p>Company: XYZ Ltd</p>
                <p>Address: 456 Oak Avenue, Townsville</p>
                <p>Contact: info@xyzltd.com</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$id}</td>
                        <td>{$amount}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        </body>
        </html>
        HTML;
    
        return $invoice;
    }    
}