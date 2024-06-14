# POTCHER

POTCHER is a website for Internet Management with Point of Sale (POS)

## Project Structure

Here is the directory structure of this project :

## Requirements
tested on :
 - PHP 8.3.0 (minimum PHP 5.4 base on codeigniter version)
 - Codeigniter Framework version 3.1.13

## Installation on Localhost
1. Clone this repository:

    ```bash
    git clone https://github.com/Fanul1/Frontend-C241-IHO1.git
    cd Frontend-C241-IHO1
    ```
2. Create user from mikrotik because admin we're not recommended using admin by default:
    - Open winbox 
    - Login create user : 
    ```bash 
    /user group add name=staff policy="ftp,reboot,read,write,policy,test,winbox,password,web,sniff,sensitive,api,romon,dude,tikapp,!telnet,!ssh,!ftp,!pptp,!l2tp,!sstp,!pptp-out,!l2tp-out,!sstp-out,!ether,!ppp,!owner,!policy,!local,!dhcp,!dial,!admin"
    /user add name=user1 group=staff password=password123
    ```

Note : you can change name and password but for group is the permission that you would like to give to this user. Copy and paste each of / marks as one query in Terminal.

3. Open your XAMPP and start the Apache in Actions

4. Open your app by url : http://localhost/Frontend-C241-IHO1/frontend

5. You gonna be headed into Login page for authentication

6. Input the field that required for login.

7. Enjoy it.

## Contribution

If you want to contribute to this project, please fork the repository and create a pull request. We appreciate your contributions!
    
