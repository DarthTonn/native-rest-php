GET /addresses/              - Returns a list of all available addresses or accepts a new address to be stored. <br />
POST /addresses/             - Creates address by POST parameters by JSON example.<br />
GET /addresses/{addressId}/  - Returns an existing address.<br />
PUT /addresses/{addressId}/  - Updates an existing address by POST parameters by JSON example.<br />

*JSON example:
{
	"label": "human",
	"street": "test street",
	"houseNumber":213,
	"postalCode": 20111,
	"city":"kiev",
	"country": "ukraine"
}