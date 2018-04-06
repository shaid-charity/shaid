require 'rubygems'
require 'oauth'
require 'json'
require 'mail'

#page created using codecademy as reference

baseurl = "https://api.twitter.com"
#path    = "/1.1/search/tweets.json"  #for searching tweets
path = "/1.1/trends/place.json" #trends
#path    = "/1.1/statuses/show.json"
#query   = URI.encode_www_form("id" => "266270116780576768")
#query = URI.encode_www_form("q" => "puppies")  #for searching tweets w/ durham
query = URI.encode_www_form("id" => "30079") #Newcastle trends (Durham does not exist)
address = URI("#{baseurl}#{path}?#{query}")
request = Net::HTTP::Get.new address.request_uri

def print_tweet(tweets)

 array = Array.new
 #puts "The current top 50 trends:"
 #puts JSON.pretty_generate(tweets)     #<prints JSON of tweet
 #tweets["trends"].each { |tweet| puts tweet["name"] }  #prints just text
 for tweet in tweets[0]["trends"] do
    #puts tweet["name"]
    array.push tweet["name"].downcase #to stop being case sensitive
   end

  hashtag = "empty"

  puts "Top 50 Trending Topics in Newcastle:"
  puts array

  found = 0
  puts "What word would you like to search for?"
  keyword = gets
  keyword = keyword.chomp #makes input a string
  keyword = keyword.downcase #to stop being case sensitive

  array.each{ |trend|
  if trend.include? keyword
    found = 1
    hashtag = trend.chomp
  end
}
  if found === 1
    puts "Keyword is trending! " + hashtag
    sendEmail(keyword,hashtag)
  else
    puts "Nothing of note going on"
  end
end


#email
def sendEmail(keyword, hashtag)

options = { :address              => "smtp.gmail.com",
            :port                 => 587,
            :user_name            => 'testhannah1996',
            :password             => 'testtesttest',
            :authentication       => 'plain',
            :enable_starttls_auto => true  }

Mail.defaults do
  delivery_method :smtp, options
end

Mail.deliver do
       to 'hannah.bellamy.1215@gmail.com'
     from 'testhannah1996@gmail.com'
  subject keyword + ' is trending!'
     body 'Notice: One of your keywords is currently trending! The trend is: ' + hashtag
end

end

#HTTP set up
http = Net::HTTP.new address.host, address.port
http.use_ssl = true
http.verify_mode = OpenSSL::SSL::VERIFY_PEER

#twitter authorisation
#NOTE: must change to SHAID account, currently Hannah's for testing
consumer_key = OAuth::Consumer.new(
    "lvW8nadoeKijsBF6zFrGKjHVr",
    "NmEOvOHkLOhHsDyk00smEirmTZ72lmTgvGgsAYNxuRMxoW16qL")
access_token = OAuth::Token.new(
    "703944336950558720-utt80LMNGr2d7XHfUTArdgE2NmJr0ME",
    "fuM6RTVqH16VVBBpUpQzWtzUefyQNeb1oDI5Rq5DYRInA")


# Sending request to Twitter
request.oauth! http, consumer_key, access_token
http.start
response = http.request request

# Check response, then print
puts response.code
tweet = nil
if response.code == '200' then
  tweet = JSON.parse(response.body)
  print_tweet(tweet)
end
