#!/bin/bash

# Function to generate random names
generate_name() {
    cat /dev/urandom | tr -dc 'a-zA-Z' | fold -w 8 | head -n 1
}

# Function to generate random last names
generate_last_name() {
    cat /dev/urandom | tr -dc 'a-zA-Z' | fold -w 10 | head -n 1
}

# Function to generate random dates
generate_date() {
    echo "$(($(date -d "2020-01-01" +%s) + RANDOM % (($(date -d "2023-12-31" +%s) - $(date -d "2020-01-01" +%s)) + 1)))"
}

# Generate CSV file
echo "name,last_name,date" > records.csv

for ((i = 0; i < 1000000; i++)); do
    name=$(generate_name)
    last_name=$(generate_last_name)
    date=$(date -d @"$(generate_date)" "+%Y-%m-%d")
    echo "$name,$last_name,$date" >> records.csv
done

echo "CSV file with 1 million records generated: records.csv"
