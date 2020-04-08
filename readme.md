# Nigerian Energy Demand
This API returns JSON arrays of Energy Demand Audit for Rural areas in Nigeria. This locations are 15km away from the National Electricity Gird in Nigeria. They are mostly populations between 4,000 and 10,000 inhabitants in Rural Nigeria. 

## Front Page URL: 
`http://energy-demand-api.herokuapp.com`

**Procedure**
- Register on `http://energy-demand-api.herokuapp.com/register`
- Click on `Create New Token`
- Copy generated Token
- Use the generated Token in the Headers as shown bellow 

## Endpoint URL: 
`http://energy-demand-api.herokuapp.com/api/communities/your@email.address`

**Payload** 
- Headers
    ```
    Accept: 'json/application'
    Authorization: 'Bearer .$Token'
    ```
 - Body
    ```
    Form Data
        tableName: 'adm1'
        value: 'kano'
    ```
