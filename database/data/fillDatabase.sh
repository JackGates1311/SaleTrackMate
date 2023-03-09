#!/bin/bash

# Define the API endpoint URL
API_URL="http://127.0.0.1:8000/api"

companies=(
    '{"company_id": "1", "tax_code": "TAX001", "reg_id": "REG001", "vat_id": "VAT001", "name": "Company 1", "country": "USA", "place": "New York", "postal_code": "10001", "address": "123 Main St", "iban": "US12345678901234567890", "bank_name": "Bank of America", "phone_num": "555-1234", "fax": "555-5678", "email": "info@example.com", "url": "https://example.com", "logo_url": "https://example.com/images/logo.png"}'
    '{"company_id": "2", "tax_code": "TAX002", "reg_id": "REG002", "vat_id": "VAT002", "name": "Company 2", "country": "USA", "place": "Los Angeles", "postal_code": "90001", "address": "456 Elm St", "iban": "US09876543210987654321", "bank_name": "Wells Fargo", "phone_num": "555-2345", "fax": "555-6789", "email": "info@company2.com", "url": "https://company2.com", "logo_url": "https://company2.com/images/logo.png"}'
    '{"company_id": "3", "tax_code": "TAX003", "reg_id": "REG003", "vat_id": "VAT003", "name": "Company 3", "country": "USA", "place": "Chicago", "postal_code": "60601", "address": "789 Oak St", "iban": "US13579024681122046913", "bank_name": "Chase", "phone_num": "555-3456", "fax": "555-7890", "email": "info@company3.com", "url": "https://company3.com", "logo_url": "https://company3.com/images/logo.png"}'
)

articles=(
  '{"company_id": "1", "article_id": "ABC123", "serial_num": "12345", "name": "Article 1", "unit": "piece", "min_unit": 1, "max_unit": 10, "price": 9.99, "description": "This is article 1", "image_url": "http://example.com/image1.jpg", "available_quantity": 100, "warranty_len": 12}'
  '{"company_id": "1", "article_id": "DEF456", "serial_num": "67890", "name": "Article 2", "unit": "meter", "min_unit": 2, "max_unit": 20, "price": 19.99, "description": "This is article 2", "image_url": "http://example.com/image2.jpg", "available_quantity": 200, "warranty_len": 24}'
  '{"company_id": "2", "article_id": "GHI789", "serial_num": "24680", "name": "Article 3", "unit": "gram", "min_unit": 3, "max_unit": 30, "price": 29.99, "description": "This is article 3", "image_url": "http://example.com/image3.jpg", "available_quantity": 300, "warranty_len": 36}'
  '{"company_id": "2", "article_id": "JKL012", "serial_num": "13579", "name": "Article 4", "unit": "liter", "min_unit": 4, "max_unit": 40, "price": 39.99, "description": "This is article 4", "image_url": "http://example.com/image4.jpg", "available_quantity": 400, "warranty_len": 48}'
  '{"company_id": "3", "article_id": "MNO345", "serial_num": "97531", "name": "Article 5", "unit": "box", "min_unit": 5, "max_unit": 50, "price": 49.99, "description": "This is article 5", "image_url": "http://example.com/image5.jpg", "available_quantity": 500, "warranty_len": 60}'
)

articlesDetails=(
    '{"article_id": "ABC123", "url": "www.pekaraas.rs/kifla/kifla1.html", "category": "food", "supplier": "Pekara AS d.o.o.", "country_origin": "Serbia", "country_origin_code": "RS", "dimensions": "23x32x12", "color": "Yellow", "weight": 200}'
    '{"article_id": "DEF456", "url": "www.kafic.com/cappuccino/cappuccino1.html", "category": "drink", "supplier": "Kafic d.o.o.", "country_origin": "Italy", "country_origin_code": "IT",  "dimensions": "20x20x10", "color": "Brown", "weight": 250}'
    '{"article_id": "GHI789", "url": "www.mesara.com/burger/burger1.html", "category": "food", "supplier": "Mesara d.o.o.", "country_origin": "USA", "country_origin_code": "US", "dimensions": "15x15x8", "color": "Red", "weight": 150}'
    '{"article_id": "JKL012", "url": "www.picerija.net/pizza/pizza1.html", "category": "food", "supplier": "Picerija d.o.o.", "country_origin": "Italy", "country_origin_code": "IT", "dimensions": "30x30x5", "color": "Red, Green, Yellow", "weight": 500}'
#'{"article_id": "MNO345", "url": "www.sneakerstore.com/air_jordan1.html", "category": "footwear", "supplier": "Sneaker Store Inc.", "country_origin": "United States", "country_origin_code": "US", "dimensions": "30x15x10", "color": "Black, Red, White", "weight": 900}'
)

for company in "${companies[@]}"
do
    response=$(curl -X POST -H "Content-Type: application/json" -d "${company}" "${API_URL}/companies")
    company_id_resp=$(echo "$response" | jq '.data.id' | tr -d '""')

    company_id=$(echo "${company}" | jq -r '.company_id')

    for ((i=0; i<${#articles[@]}; i++)); do

        company_id_articles=$(echo "${articles[$i]}" | jq -r '.company_id')

        if [ "$company_id" == "$company_id_articles" ]; then
            articles[$i]=$(echo "${articles[$i]}" | jq --arg company_id_resp "$company_id_resp" '. + {company_id: $company_id_resp}' | sed 's/\(["\]\)/\\\1/g' | sed 's/^"\|"$//g' | tr -d '\')
        fi
    done
done

for article in "${articles[@]}"; do

    response=$(curl -X POST -H "Content-Type: application/json" -d "${article}" "${API_URL}/articles")
    article_id_resp=$(echo "$response" | jq '.data.id' | tr -d '""')

    article_id=$(echo "${article}" | jq -r '.article_id')

    for ((i=0; i<${#articlesDetails[@]}; i++)); do

        article_id_article_details=$(echo "${articlesDetails[$i]}" | jq -r '.article_id')

        if [ "$article_id" == "$article_id_article_details" ]; then
            articlesDetails[$i]=$(echo "${articlesDetails[$i]}" | jq --arg article_id_resp "$article_id_resp" '. + {article_id: $article_id_resp}' | sed 's/\(["\]\)/\\\1/g' | sed 's/^"\|"$//g' | tr -d '\')
            curl -X POST -H "Content-Type: application/json" -d "${articlesDetails[$i]}" "${API_URL}/articlesDetails"
        fi
    done
done
