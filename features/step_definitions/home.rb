require 'selenium-webdriver'
browser = Selenium::WebDriver.for(:firefox)

Given(/^I am on the main page$/) do
   browser.get('http://localhost')
end

Then(/^there is a graph$/) do
   browser.find_element(:id, 'LineChart').displayed?   
end

Then(/^there is a CSV upload form$/) do
   browser.find_element(:id, 'transaction').displayed?
end

Then(/^there is an account list$/) do
   browser.find_element(:id, 'portfolio').displayed?
end
